<?php
// app/Http/Controllers/Etablissement/PersonnelController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StorePersonnelRequest;
use App\Http\Requests\Etablissement\UpdatePersonnelRequest;
use App\Models\Etablissement\Personnel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class PersonnelController extends Controller
{
    public function index(Request $request)
    {
        $query = Personnel::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('fonction', 'like', "%{$search}%");
            });
        }

        if ($request->filled('est_actif')) {
            $query->where('est_actif', $request->boolean('est_actif'));
        }

        $personnels = $query->orderBy('nom')->paginate(10);

        return view('etablissement.personnels.index', compact('personnels'));
    }

    public function create()
    {
        return view('etablissement.personnels.create');
    }

    public function store(StorePersonnelRequest $request)
    {
        $data = $request->validated();
        $personnel = Personnel::create($data);

        return redirect()->route('personnels.index')
            ->with('success', 'Personnel créé avec succès.');
    }

    public function show(Personnel $personnel)
    {
        $personnel->load(['user', 'departementDirige', 'matieres']);
        return view('etablissement.personnels.show', compact('personnel'));
    }

    public function edit(Personnel $personnel)
    {
        return view('etablissement.personnels.edit', compact('personnel'));
    }

    public function update(UpdatePersonnelRequest $request, Personnel $personnel)
    {
        $personnel->update($request->validated());

        return redirect()->route('personnels.index')
            ->with('success', 'Personnel mis à jour avec succès.');
    }

    public function destroy(Personnel $personnel)
    {
        if ($personnel->departementDirige()->exists()) {
            return back()->with('error', 'Impossible de supprimer un chef de département.');
        }

        if ($personnel->matieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer un personnel qui enseigne des matières.');
        }

        $personnel->delete();

        return redirect()->route('personnels.index')
            ->with('success', 'Personnel supprimé avec succès.');
    }

    public function toggleStatus(Personnel $personnel)
    {
        $personnel->update(['est_actif' => !$personnel->est_actif]);

        return redirect()->route('personnels.index')
            ->with('success', 'Statut du personnel modifié avec succès.');
    }

    public function createUser(Personnel $personnel)
    {
        if ($personnel->user_id) {
            return redirect()->route('personnels.show', $personnel)
                ->with('error', 'Ce personnel a déjà un compte utilisateur.');
        }

        $roles = Role::all();
        return view('etablissement.personnels.create-user', compact('personnel', 'roles'));
    }

    public function storeUser(Request $request, Personnel $personnel)
    {
        if ($personnel->user_id) {
            return back()->with('error', 'Ce personnel a déjà un compte utilisateur.');
        }

        $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $personnel->nom_complet,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);
        $personnel->update(['user_id' => $user->id]);

        return redirect()->route('personnels.show', $personnel)
            ->with('success', 'Compte utilisateur créé avec succès.');
    }

    public function detachUser(Personnel $personnel)
    {
        if (!$personnel->user_id) {
            return back()->with('error', 'Ce personnel n\'a pas de compte utilisateur.');
        }

        $personnel->update(['user_id' => null]);

        return redirect()->route('personnels.show', $personnel)
            ->with('success', 'Compte utilisateur détaché avec succès.');
    }
}
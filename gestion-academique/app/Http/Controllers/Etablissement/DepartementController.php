<?php
// app/Http/Controllers/Etablissement/DepartementController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreDepartementRequest;
use App\Http\Requests\Etablissement\UpdateDepartementRequest;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Personnel;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::with(['chefDepartement', 'specialites'])
            ->orderBy('libelle')
            ->paginate(10);

        return view('etablissement.departements.index', compact('departements'));
    }

    public function create()
    {
            $personnels = Personnel::select(
                'id',
                'matricule',
                'nom',
                'prenom'
            )
            ->where('est_actif', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('etablissement.departements.create', compact('personnels'));
    }

    public function store(StoreDepartementRequest $request)
    {
        Departement::create($request->validated());

        return redirect()->route('departements.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function show(Departement $departement)
    {
        $departement->load(['chefDepartement', 'specialites', 'niveaux']);
        return view('etablissement.departements.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
            $personnels = Personnel::select(
                'id',
                'matricule',
                'nom',
                'prenom'
            )
            ->where('est_actif', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('etablissement.departements.edit', compact('departement', 'personnels'));
    }

    public function update(UpdateDepartementRequest $request, Departement $departement)
    {
        $departement->update($request->validated());

        return redirect()->route('departements.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Departement $departement)
    {
            if (
                $departement->specialites()->exists()
                || $departement->niveaux()->exists()
            ) {

            return back()->with(
                'error',
                'Impossible de supprimer ce département car il est utilisé.'
    );
}

        $departement->delete();

        return redirect()->route('departements.index')
            ->with('success', 'Département supprimé avec succès.');
    }

    public function toggleStatus(Departement $departement)
    {
        $departement->update(['est_actif' => !$departement->est_actif]);

        return redirect()->route('departements.index')
            ->with('success', 'Statut du département modifié avec succès.');
    }

  public function nommerChef(Request $request, Departement $departement)
{
    $data = $request->validate([

        'personnel_id' => [

            'required',

            Rule::exists('personnels', 'id')
                ->where(fn ($query) => $query->where('est_actif', true))

        ]

    ]);

    $departement->update([
        'chef_departement_id' => $data['personnel_id']
    ]);

    return redirect()
        ->route('departements.show', $departement)
        ->with('success', 'Chef de département nommé avec succès.');
}

    public function retirerChef(Departement $departement)
    {
        $departement->update(['chef_departement_id' => null]);

        return redirect()->route('departements.show', $departement)
            ->with('success', 'Chef de département retiré avec succès.');
    }
}
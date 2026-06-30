<?php
// app/Http/Controllers/EtudiantController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::orderBy('nom')->paginate(15);
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(StoreEtudiantRequest $request)
    {
        $data = $request->validated();
        
        // Générer le matricule automatiquement
        $year = date('Y');
        $last = Etudiant::where('matricule', 'like', "{$year}%")->count();
        $number = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        $data['matricule'] = "{$year}{$number}";

        Etudiant::create($data);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant ajouté avec succès. Matricule: ' . $data['matricule']);
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load('inscriptions');
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant)
    {
        $etudiant->update($request->validated());

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }

    public function toggleStatus(Etudiant $etudiant)
    {
        $etudiant->update(['est_actif' => !$etudiant->est_actif]);

        $status = $etudiant->est_actif ? 'activé' : 'désactivé';

        return redirect()->route('etudiants.index')
            ->with('success', "Étudiant {$status} avec succès.");
    }
}
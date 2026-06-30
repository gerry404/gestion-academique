<?php
// app/Http/Controllers/InscriptionController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscriptionRequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Specialite;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        $etudiants = Etudiant::where('est_actif', true)->orderBy('nom')->get();
        $annees = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $specialites = Specialite::where('est_actif', true)->orderBy('libelle')->get();
        $niveaux = Niveau::where('est_actif', true)->orderBy('libelle')->get();

        return view('inscriptions.create', compact('etudiants', 'annees', 'departements', 'specialites', 'niveaux'));
    }

    public function store(StoreInscriptionRequest $request)
    {
        $data = $request->validated();
        $data['date_inscription'] = now();

        Inscription::create($data);

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription enregistrée avec succès.');
    }

    public function show(Inscription $inscription)
    {
        $inscription->load(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau']);
        return view('inscriptions.show', compact('inscription'));
    }

    public function edit(Inscription $inscription)
    {
        $etudiants = Etudiant::where('est_actif', true)->orderBy('nom')->get();
        $annees = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $specialites = Specialite::where('est_actif', true)->orderBy('libelle')->get();
        $niveaux = Niveau::where('est_actif', true)->orderBy('libelle')->get();

        return view('inscriptions.edit', compact('inscription', 'etudiants', 'annees', 'departements', 'specialites', 'niveaux'));
    }

    public function update(StoreInscriptionRequest $request, Inscription $inscription)
    {
        $inscription->update($request->validated());

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }

    public function valider(Inscription $inscription)
    {
        $inscription->update(['statut' => 'validee']);

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription validée avec succès.');
    }

    public function annuler(Inscription $inscription)
    {
        $inscription->update(['statut' => 'annulee']);

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription annulée avec succès.');
    }
}
<?php
// app/Http/Controllers/InscriptionController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscriptionRequest;
use App\Models\Inscription;
use App\Models\Etudiant;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Specialite;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    /**
     * Liste des inscriptions
     */
    public function index()
    {
        $inscriptions = Inscription::with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('inscriptions.index', compact('inscriptions'));
    }

    /**
     * Formulaire de création d'inscription
     */
    public function create()
    {
        // Récupérer tous les étudiants actifs
        $etudiants = Etudiant::where('est_actif', true)
            ->orderBy('nom')
            ->get();

        // Récupérer les années académiques actives
        $annees = AnneeAcademique::where('est_active', true)
            ->orderBy('libelle', 'desc')
            ->get();

        // Récupérer les départements actifs
        $departements = Departement::where('est_actif', true)
            ->orderBy('libelle')
            ->get();

        // Récupérer les spécialités actives
        $specialites = Specialite::where('est_actif', true)
            ->orderBy('libelle')
            ->get();

        // Récupérer les niveaux actifs
        $niveaux = Niveau::where('est_actif', true)
            ->orderBy('libelle')
            ->get();

        return view('inscriptions.create', compact('etudiants', 'annees', 'departements', 'specialites', 'niveaux'));
    }

    /**
     * Enregistrer une nouvelle inscription
     */
    public function store(StoreInscriptionRequest $request)
    {
        $data = $request->validated();
        
        // Vérifier si l'étudiant est déjà inscrit pour cette année et ce niveau
        $existingInscription = Inscription::where('etudiant_id', $data['etudiant_id'])
            ->where('annee_academique_id', $data['annee_academique_id'])
            ->where('niveau_id', $data['niveau_id'])
            ->whereIn('statut', ['en_attente', 'validee'])
            ->first();

        if ($existingInscription) {
            return back()
                ->withInput()
                ->withErrors(['etudiant_id' => 'Cet étudiant est déjà inscrit pour cette année et ce niveau.']);
        }

        // Ajouter la date d'inscription
        $data['date_inscription'] = now();

        // Créer l'inscription
        Inscription::create($data);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription enregistrée avec succès.');
    }

    /**
     * Afficher les détails d'une inscription
     */
    public function show(Inscription $inscription)
    {
        $inscription->load(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau']);
        return view('inscriptions.show', compact('inscription'));
    }

    /**
     * Formulaire de modification d'inscription
     */
    public function edit(Inscription $inscription)
    {
        $etudiants = Etudiant::where('est_actif', true)->orderBy('nom')->get();
        $annees = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $specialites = Specialite::where('est_actif', true)->orderBy('libelle')->get();
        $niveaux = Niveau::where('est_actif', true)->orderBy('libelle')->get();

        return view('inscriptions.edit', compact('inscription', 'etudiants', 'annees', 'departements', 'specialites', 'niveaux'));
    }

    /**
     * Mettre à jour une inscription
     */
    public function update(StoreInscriptionRequest $request, Inscription $inscription)
    {
        $data = $request->validated();

        // Vérifier si l'étudiant est déjà inscrit pour cette année et ce niveau (sauf pour cette inscription)
        $existingInscription = Inscription::where('etudiant_id', $data['etudiant_id'])
            ->where('annee_academique_id', $data['annee_academique_id'])
            ->where('niveau_id', $data['niveau_id'])
            ->where('id', '!=', $inscription->id)
            ->whereIn('statut', ['en_attente', 'validee'])
            ->first();

        if ($existingInscription) {
            return back()
                ->withInput()
                ->withErrors(['etudiant_id' => 'Cet étudiant est déjà inscrit pour cette année et ce niveau.']);
        }

        $inscription->update($data);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription mise à jour avec succès.');
    }

    /**
     * Supprimer une inscription
     */
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès.');
    }

    /**
     * Valider une inscription
     */
    public function valider(Inscription $inscription)
    {
        // Vérifier que l'inscription est en attente
        if ($inscription->statut !== 'en_attente') {
            return back()->with('error', 'Seules les inscriptions en attente peuvent être validées.');
        }

        $inscription->update(['statut' => 'validee']);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription validée avec succès.');
    }

    /**
     * Annuler une inscription
     */
    public function annuler(Inscription $inscription)
    {
        // Vérifier que l'inscription est en attente ou validée
        if (!in_array($inscription->statut, ['en_attente', 'validee'])) {
            return back()->with('error', 'Cette inscription ne peut pas être annulée.');
        }

        $inscription->update(['statut' => 'annulee']);

        return redirect()
            ->route('inscriptions.index')
            ->with('success', 'Inscription annulée avec succès.');
    }


    /**
 * Récupérer les spécialités par département (AJAX)
 */
 public function getSpecialitesByDepartement(Request $request)
{
    $departementId = $request->departement_id;
    
    $specialites = Specialite::where('departement_id', $departementId)
        ->where('est_actif', true)
        ->orderBy('libelle')
        ->get(['id', 'libelle', 'code']);

    return response()->json($specialites);
}

/**
 * Récupérer les niveaux par spécialité (AJAX)
 */
public function getNiveauxBySpecialite(Request $request)
{
    $specialiteId = $request->specialite_id;
    
    $niveaux = Niveau::where('specialite_id', $specialiteId)
        ->where('est_actif', true)
        ->orderBy('libelle')
        ->get(['id', 'libelle']);

    return response()->json($niveaux);
}
}
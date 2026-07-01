<?php
// app/Http/Controllers/Notes/NoteController.php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\StoreNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Matiere;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\Specialite;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::with(['etudiant', 'matiere', 'inscription', 'semestre']);

        if ($request->filled('annee_academique_id')) {
            $query->whereHas('inscription', function ($q) use ($request) {
                $q->where('annee_academique_id', $request->annee_academique_id);
            });
        }

        if ($request->filled('semestre_id')) {
            $query->where('semestre_id', $request->semestre_id);
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        $notes = $query->orderBy('created_at', 'desc')->paginate(20);

        $annees = AnneeAcademique::orderBy('libelle', 'desc')->get();
        $semestres = Semestre::orderBy('libelle')->get();
        $matieres = Matiere::where('est_actif', true)->get();

        return view('notes.index', compact('notes', 'annees', 'semestres', 'matieres'));
    }

    public function create(Request $request)
    {
        // Étape 1: Récupérer les années académiques
        $annees = AnneeAcademique::orderBy('libelle', 'desc')->get();

        // Étape 2: Si année sélectionnée, récupérer les spécialités
        $specialites = collect();
        if ($request->filled('annee_academique_id')) {
            $specialites = Specialite::where('est_actif', true)
                ->with(['departement'])
                ->orderBy('libelle')
                ->get();
        }

        // Étape 3: Si spécialité sélectionnée, récupérer les niveaux
        $niveaux = collect();
        if ($request->filled('specialite_id')) {
            $niveaux = Niveau::where('specialite_id', $request->specialite_id)
                ->where('est_actif', true)
                ->orderBy('libelle')
                ->get();
        }

        // Étape 4: Si niveau sélectionné, récupérer les semestres
        $semestres = collect();
        if ($request->filled('niveau_id')) {
            $semestres = Semestre::where('niveau_id', $request->niveau_id)
                ->orderBy('libelle')
                ->get();
        }

        // Étape 5: Si semestre sélectionné, récupérer les matières
        $matieres = collect();
        if ($request->filled('semestre_id')) {
            $matieres = Matiere::where('semestre_id', $request->semestre_id)
                ->where('est_actif', true)
                ->orderBy('libelle')
                ->get();
        }

        // Étape 6: Si matière sélectionnée, récupérer les étudiants inscrits
        $etudiants = collect();
        $inscriptionId = null;
        if ($request->filled('matiere_id') && $request->filled('annee_academique_id')) {
            $matiere = Matiere::find($request->matiere_id);
            if ($matiere) {
                $etudiants = Etudiant::whereHas('inscriptions', function ($q) use ($request, $matiere) {
                    $q->where('annee_academique_id', $request->annee_academique_id)
                        ->where('niveau_id', $matiere->niveau_id)
                        ->where('statut', 'validee');
                })->orderBy('nom')->get();
            }
        }

        // Pré-sélection
        $selectedAnnee = $request->query('annee_academique_id');
        $selectedSpecialite = $request->query('specialite_id');
        $selectedNiveau = $request->query('niveau_id');
        $selectedSemestre = $request->query('semestre_id');
        $selectedMatiere = $request->query('matiere_id');

        return view('notes.create', compact(
            'annees', 'specialites', 'niveaux', 'semestres', 'matieres', 'etudiants',
            'selectedAnnee', 'selectedSpecialite', 'selectedNiveau',
            'selectedSemestre', 'selectedMatiere'
        ));
    }

    public function store(StoreNoteRequest $request)
    {
        $cc = $request->note_cc;
        $examen = $request->note_examen;
        $moyenne = Note::calculateMoyenne($cc, $examen);

        // Récupérer le crédit de la matière
        $matiere = Matiere::find($request->matiere_id);

        Note::create([
            'etudiant_id' => $request->etudiant_id,
            'matiere_id' => $request->matiere_id,
            'inscription_id' => $request->inscription_id,
            'semestre_id' => $request->semestre_id,
            'note_cc' => $cc,
            'note_examen' => $examen,
            'moyenne' => $moyenne,
            'credit' => $matiere->credit ?? 0,
            'statut' => 'valide',
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note enregistrée avec succès. Moyenne: ' . number_format($moyenne, 2));
    }

    public function show(Note $note)
    {
        $note->load(['etudiant', 'matiere', 'inscription', 'semestre']);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $cc = $request->note_cc;
        $examen = $request->note_examen;
        $moyenne = Note::calculateMoyenne($cc, $examen);

        $note->update([
            'note_cc' => $cc,
            'note_examen' => $examen,
            'moyenne' => $moyenne,
        ]);

        return redirect()->route('notes.index')
            ->with('success', 'Note mise à jour avec succès.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès.');
    }

    // AJAX: Récupérer les spécialités par année
    public function getSpecialitesByAnnee(Request $request)
    {
        $specialites = Specialite::where('est_actif', true)
            ->with(['departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($specialite) {
                return [
                    'id' => $specialite->id,
                    'libelle' => $specialite->libelle . ' (' . ($specialite->departement->libelle ?? '') . ')',
                ];
            });

        return response()->json($specialites);
    }

    // AJAX: Récupérer les niveaux par spécialité
    public function getNiveauxBySpecialite(Request $request)
    {
        $niveaux = Niveau::where('specialite_id', $request->specialite_id)
            ->where('est_actif', true)
            ->orderBy('libelle')
            ->get(['id', 'libelle']);

        return response()->json($niveaux);
    }

    // AJAX: Récupérer les semestres par niveau
    public function getSemestresByNiveau(Request $request)
    {
        $semestres = Semestre::where('niveau_id', $request->niveau_id)
            ->orderBy('libelle')
            ->get(['id', 'libelle']);

        return response()->json($semestres);
    }

    // AJAX: Récupérer les matières par semestre
    public function getMatieresBySemestre(Request $request)
    {
        $matieres = Matiere::where('semestre_id', $request->semestre_id)
            ->where('est_actif', true)
            ->orderBy('libelle')
            ->get(['id', 'libelle', 'credit']);

        return response()->json($matieres);
    }

    // AJAX: Récupérer les étudiants par matière et année
    public function getEtudiantsByMatiere(Request $request)
    {
        $matiere = Matiere::find($request->matiere_id);
        
        if (!$matiere) {
            return response()->json([]);
        }

        $etudiants = Etudiant::whereHas('inscriptions', function ($q) use ($request, $matiere) {
            $q->where('annee_academique_id', $request->annee_academique_id)
                ->where('niveau_id', $matiere->niveau_id)
                ->where('statut', 'validee');
        })->orderBy('nom')->get(['id', 'nom', 'prenom', 'matricule']);

        return response()->json($etudiants);
    }

    // AJAX: Récupérer l'inscription d'un étudiant
    public function getInscription(Request $request)
    {
        $inscription = Inscription::where('etudiant_id', $request->etudiant_id)
            ->where('annee_academique_id', $request->annee_academique_id)
            ->where('statut', 'validee')
            ->first();

        return response()->json($inscription);
    }
}
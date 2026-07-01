<?php
// app/Http/Controllers/Etablissement/MatiereController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreMatiereRequest;
use App\Http\Requests\Etablissement\UpdateMatiereRequest;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Matiere;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Personnel;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\UniteEnseignement;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index(Request $request)
    {
        $query = Matiere::with(['departement', 'uniteEnseignement', 'semestre', 'niveau', 'personnel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        if ($request->filled('unite_enseignement_id')) {
            $query->where('unite_enseignement_id', $request->unite_enseignement_id);
        }

        if ($request->filled('semestre_id')) {
            $query->where('semestre_id', $request->semestre_id);
        }

        if ($request->filled('niveau_id')) {
            $query->where('niveau_id', $request->niveau_id);
        }

        $matieres = $query->orderBy('code')->paginate(10);

        $ues = UniteEnseignement::with('niveau')->orderBy('libelle')->get();
        $semestres = Semestre::with('anneeAcademique')->orderBy('libelle')->get();
        $niveaux = Niveau::with('specialite')
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                return $niveau;
            });

        return view('etablissement.matieres.index', compact('matieres', 'ues', 'semestres', 'niveaux'));
    }

    public function create(Request $request)
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $personnels   = Personnel::where('est_actif', true)->orderBy('nom')->get();

        // Variables pour la vue (vides, remplies par AJAX)
        $ues = collect();
        $semestres = Semestre::orderBy('libelle')->get();
        $niveaux = collect();

        $selectedUE       = $request->query('unite_enseignement_id');
        $selectedSemestre = $request->query('semestre_id');
        $selectedNiveau   = $request->query('niveau_id');

        return view('etablissement.matieres.create', compact(
            'departements', 'personnels', 'ues', 'semestres', 'niveaux',
            'selectedUE', 'selectedSemestre', 'selectedNiveau'
        ));
    }

    public function store(StoreMatiereRequest $request)
    {
        Matiere::create($request->validated());

        return redirect()->route('matieres.index')
            ->with('success', 'Matière créée avec succès.');
    }

    public function show(Matiere $matiere)
    {
        $matiere->load(['departement', 'uniteEnseignement', 'semestre', 'niveau', 'personnel']);
        return view('etablissement.matieres.show', compact('matiere'));
    }

    public function edit(Matiere $matiere)
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $personnels   = Personnel::where('est_actif', true)->orderBy('nom')->get();

        $matiere->load('niveau', 'uniteEnseignement', 'semestre');

        return view('etablissement.matieres.edit', compact('matiere', 'departements', 'personnels'));
    }

    public function update(UpdateMatiereRequest $request, Matiere $matiere)
    {
        $matiere->update($request->validated());

        return redirect()->route('matieres.index')
            ->with('success', 'Matière mise à jour avec succès.');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return redirect()->route('matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }

    public function toggleStatus(Matiere $matiere)
    {
        $matiere->update(['est_actif' => !$matiere->est_actif]);

        $status = $matiere->est_actif ? 'activée' : 'désactivée';

        return redirect()->route('matieres.index')
            ->with('success', "Matière {$status} avec succès.");
    }

    // ═══════════════════════════════════════════════
    // ROUTES AJAX — cascade departement → niveau → semestre/UE
    // ═══════════════════════════════════════════════

    /**
     * Niveaux d'un département
     */
    public function getNiveauxByDepartement(Request $request)
    {
        $request->validate(['departement_id' => ['required', 'exists:departements,id']]);

        $niveaux = Niveau::where('departement_id', $request->departement_id)
            ->where('est_actif', true)
            ->with('specialite')
            ->orderBy('libelle')
            ->get()
            ->map(fn($niveau) => [
                'id'             => $niveau->id,
                'libelle'        => $niveau->libelle,
                'display_name'   => $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')',
                'specialite_id'  => $niveau->specialite_id,
                'annee_academique_id' => $niveau->annee_academique_id,
            ]);

        return response()->json($niveaux);
    }
/**
 * Récupère les semestres d'un niveau via les UE
 */
public function getSemestresByNiveau(Request $request)
{
    $request->validate(['niveau_id' => ['required', 'exists:niveaux,id']]);

    // Récupérer les UE du niveau
    $ues = UniteEnseignement::where('niveau_id', $request->niveau_id)->pluck('id');
    
    // Récupérer les semestres des matières de ces UE
    $semestres = Semestre::whereHas('matieres', function ($query) use ($ues) {
            $query->whereIn('unite_enseignement_id', $ues);
        })
        ->distinct()
        ->orderBy('libelle')
        ->get(['id', 'libelle']);

    // Si aucun semestre trouvé via les UE, retourner un tableau vide
    return response()->json($semestres);
}

    /**
     * UE du niveau choisi
     */
    public function getUesByNiveau(Request $request)
    {
        $request->validate(['niveau_id' => ['required', 'exists:niveaux,id']]);

        $ues = UniteEnseignement::where('niveau_id', $request->niveau_id)
            ->orderBy('libelle')
            ->get(['id', 'libelle', 'total_credit']);

        return response()->json($ues);
    }
}
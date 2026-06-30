<?php
// app/Http/Controllers/Etablissement/SemestreController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreSemestreRequest;
use App\Http\Requests\Etablissement\UpdateSemestreRequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Semestre;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    public function index(Request $request)
    {
        $query = Semestre::with(['anneeAcademique', 'niveau']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('libelle', 'like', "%{$search}%");
        }

        if ($request->filled('annee_academique_id')) {
            $query->where('annee_academique_id', $request->annee_academique_id);
        }

        if ($request->filled('niveau_id')) {
            $query->where('niveau_id', $request->niveau_id);
        }

        $semestres = $query->orderBy('libelle')->paginate(10);

        // Données pour les filtres
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                return $niveau;
            });

        return view('etablissement.semestres.index', compact('semestres', 'anneesAcademiques', 'niveaux'));
    }

    public function create()
    {
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                return $niveau;
            });

        return view('etablissement.semestres.create', compact('anneesAcademiques', 'niveaux'));
    }

    public function store(StoreSemestreRequest $request)
    {
        Semestre::create($request->validated());

        return redirect()->route('semestres.index')
            ->with('success', 'Semestre créé avec succès.');
    }

    public function show(Semestre $semestre)
    {
        $semestre->load(['anneeAcademique', 'niveau', 'matieres']);
        return view('etablissement.semestres.show', compact('semestre'));
    }

    public function edit(Semestre $semestre)
    {
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                return $niveau;
            });

        return view('etablissement.semestres.edit', compact('semestre', 'anneesAcademiques', 'niveaux'));
    }

    public function update(UpdateSemestreRequest $request, Semestre $semestre)
    {
        $semestre->update($request->validated());

        return redirect()->route('semestres.index')
            ->with('success', 'Semestre mis à jour avec succès.');
    }

    public function destroy(Semestre $semestre)
    {
        // Vérifier si des matières sont liées
        if ($semestre->matieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce semestre car il contient des matières.');
        }

        $semestre->delete();

        return redirect()->route('semestres.index')
            ->with('success', 'Semestre supprimé avec succès.');
    }
}
<?php
// app/Http/Controllers/Etablissement/UEController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreUERequest;
use App\Http\Requests\Etablissement\UpdateUERequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\UniteEnseignement;
use Illuminate\Http\Request;

class UEController extends Controller
{
    public function index(Request $request)
    {
        $query = UniteEnseignement::with(['anneeAcademique', 'niveau.specialite']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        if ($request->filled('annee_academique_id')) {
            $query->where('annee_academique_id', $request->annee_academique_id);
        }

        if ($request->filled('niveau_id')) {
            $query->where('niveau_id', $request->niveau_id);
        }

        $ues = $query->orderBy('code')->paginate(10);

        // Données pour les filtres
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        // ✅ Récupérer les niveaux avec leur spécialité
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                $niveau->display_full = $niveau->libelle . ' - ' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ' (' . ($niveau->departement->libelle ?? '') . ')';
                return $niveau;
            });

        return view('etablissement.ues.index', compact('ues', 'anneesAcademiques', 'niveaux'));
    }

    public function create()
    {
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        // ✅ Récupérer les niveaux avec leur spécialité et département
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                $niveau->display_full = $niveau->libelle . ' - ' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ' (' . ($niveau->departement->libelle ?? '') . ')';
                return $niveau;
            });

        return view('etablissement.ues.create', compact('anneesAcademiques', 'niveaux'));
    }

    public function store(StoreUERequest $request)
    {
        UniteEnseignement::create($request->validated());

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement créée avec succès.');
    }

    public function show(UniteEnseignement $ue)
    {
        $ue->load(['anneeAcademique', 'niveau.specialite', 'matieres']);
        return view('etablissement.ues.show', compact('ue'));
    }

    public function edit(UniteEnseignement $ue)
    {
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        // ✅ Récupérer les niveaux avec leur spécialité et département
        $niveaux = Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                $niveau->display_full = $niveau->libelle . ' - ' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ' (' . ($niveau->departement->libelle ?? '') . ')';
                return $niveau;
            });

        return view('etablissement.ues.edit', compact('ue', 'anneesAcademiques', 'niveaux'));
    }

    public function update(UpdateUERequest $request, UniteEnseignement $ue)
    {
        $ue->update($request->validated());

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement mise à jour avec succès.');
    }

    public function destroy(UniteEnseignement $ue)
    {
        if ($ue->matieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette UE car elle contient des matières.');
        }

        $ue->delete();

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement supprimée avec succès.');
    }
}
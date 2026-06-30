<?php
// app/Http/Controllers/Etablissement/AnneeAcademiqueController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreAnneeAcademiqueRequest;
use App\Http\Requests\Etablissement\UpdateAnneeAcademiqueRequest;
use App\Models\Etablissement\AnneeAcademique;
use Illuminate\Http\Request;

class AnneeAcademiqueController extends Controller
{
    public function index()
    {
        $annees = AnneeAcademique::orderBy('libelle', 'desc')->paginate(10);
        return view('etablissement.annees.index', compact('annees'));
    }

    public function create()
    {
        return view('etablissement.annees.create');
    }

    public function store(StoreAnneeAcademiqueRequest $request)
    {
        $data = $request->validated();
        
        // Si c'est la première année, l'activer automatiquement
        if (AnneeAcademique::count() === 0) {
            $data['est_active'] = true;
        }

        AnneeAcademique::create($data);

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Année académique créée avec succès.');
    }

            public function show(AnneeAcademique $anneeAcademique)
        {
            $anneeAcademique->load([
                'niveaux',
                'semestres',
                'unitesEnseignement',
            ]);

    return view('etablissement.annees.show', compact('anneeAcademique'));
}

    public function edit(AnneeAcademique $anneeAcademique)
    {
        return view('etablissement.annees.edit', compact('anneeAcademique'));
    }

    public function update(UpdateAnneeAcademiqueRequest $request, AnneeAcademique $anneeAcademique)
    {
        if ($anneeAcademique->est_active && $request->has('est_active') && !$request->est_active) {
            return back()->with('error', 'Impossible de désactiver l\'année académique active.');
        }

        $anneeAcademique->update($request->validated());

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Année académique mise à jour avec succès.');
    }

    public function destroy(AnneeAcademique $anneeAcademique)
    {
        if ($anneeAcademique->est_active) {
            return back()->with('error', 'Impossible de supprimer l\'année académique active.');
        }

        $anneeAcademique->delete();

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Année académique supprimée avec succès.');
    }

    public function activate(AnneeAcademique $anneeAcademique)
    {
        AnneeAcademique::where('est_active', true)->update(['est_active' => false]);
        $anneeAcademique->update(['est_active' => true]);

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Année académique activée avec succès.');
    }

    public function deactivate(AnneeAcademique $anneeAcademique)
    {
        if (!$anneeAcademique->est_active) {
            return back()->with('error', 'Cette année académique est déjà inactive.');
        }

        $anneeAcademique->update(['est_active' => false]);

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Année académique désactivée avec succès.');
    }

    public function toggleStatus(AnneeAcademique $anneeAcademique)
    {
        if (!$anneeAcademique->est_active) {
            AnneeAcademique::where('est_active', true)->update(['est_active' => false]);
        }

        $anneeAcademique->update(['est_active' => !$anneeAcademique->est_active]);

        return redirect()->route('annees-academiques.index')
            ->with('success', 'Statut de l\'année académique modifié avec succès.');
    }
}
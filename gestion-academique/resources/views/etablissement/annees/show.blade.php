{{-- resources/views/etablissement/annees/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails année académique - EduManager')

@php
    $pageTitle = 'Détails année académique';
    $pageSub = 'Informations complètes de l\'année';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $anneeAcademique->libelle }}</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ $anneeAcademique->date_debut?->format('d/m/Y') }} - {{ $anneeAcademique->date_fin?->format('d/m/Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $anneeAcademique->est_active ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ $anneeAcademique->est_active ? 'Actif' : 'Inactif' }}
                    </span>
                    <a href="{{ route('annees-academiques.edit', $anneeAcademique) }}"
                       class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg text-sm font-semibold hover:bg-amber-200 transition">
                        <i class="fa-solid fa-pen"></i> Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $anneeAcademique->libelle }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Note de validation</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $anneeAcademique->note_validation }}/20</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date début</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $anneeAcademique->date_debut?->format('d/m/Y') }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date fin</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $anneeAcademique->date_fin?->format('d/m/Y') }}</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</label>
                    <p class="text-slate-800 mt-1">{{ $anneeAcademique->description ?? 'Aucune description' }}</p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations supplémentaires</h4>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $anneeAcademique->niveaux->count() }}</div>
                        <div class="text-xs text-slate-500">Niveaux</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $anneeAcademique->semestres->count() }}</div>
                        <div class="text-xs text-slate-500">Semestres</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $anneeAcademique->unitesEnseignement->count() }}</div>
                        <div class="text-xs text-slate-500">Unités d\'enseignement</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('annees-academiques.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
           
            <form action="{{ route('annees-academiques.destroy', $anneeAcademique) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de cette année académique ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
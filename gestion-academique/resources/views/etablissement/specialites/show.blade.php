{{-- resources/views/etablissement/specialites/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails spécialité - EduManager')

@php
    $pageTitle = 'Détails spécialité';
    $pageSub = 'Informations complètes de la spécialité';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">{{ $specialite->libelle }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $specialite->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $specialite->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">Code: {{ $specialite->code }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('specialites.edit', $specialite) }}"
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
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Code</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $specialite->code }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $specialite->libelle }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Département</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="inline-flex items-center gap-1">
                            {{ $specialite->departement->libelle ?? '-' }}
                            <span class="text-xs text-slate-400">({{ $specialite->departement->code ?? '' }})</span>
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $specialite->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $specialite->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</label>
                    <p class="text-slate-800 mt-1">{{ $specialite->description ?? 'Aucune description' }}</p>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations supplémentaires</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $specialite->niveaux->count() }}</div>
                        <div class="text-xs text-slate-500">Niveaux</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $specialite->options->count() }}</div>
                        <div class="text-xs text-slate-500">Options</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('specialites.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="{{ route('specialites.edit', $specialite) }}"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            <form action="{{ route('specialites.destroy', $specialite) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de cette spécialité ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
            <form action="{{ route('specialites.toggle-status', $specialite) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="px-4 py-2.5 {{ $specialite->est_actif ? 'bg-slate-600' : 'bg-emerald-600' }} text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid {{ $specialite->est_actif ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                    {{ $specialite->est_actif ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
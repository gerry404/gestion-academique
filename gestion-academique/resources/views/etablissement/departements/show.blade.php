{{-- resources/views/etablissement/departements/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails département - EduManager')

@php
    $pageTitle = 'Détails département';
    $pageSub = 'Informations complètes du département';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">{{ $departement->libelle }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $departement->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $departement->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">Code: {{ $departement->code }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('departements.edit', $departement) }}"
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
                    <p class="text-slate-800 font-medium mt-1">{{ $departement->code }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $departement->libelle }}</p>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Description</label>
                    <p class="text-slate-800 mt-1">{{ $departement->description ?? 'Aucune description' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Chef de département</label>
                    @if($departement->chefDepartement)
                        <p class="text-slate-800 font-medium mt-1">
                            {{ $departement->chefDepartement->prenom }} {{ $departement->chefDepartement->nom }}
                            <span class="text-sm text-slate-500 block">{{ $departement->chefDepartement->matricule }}</span>
                        </p>
                    @else
                        <p class="text-slate-400 mt-1">Non défini</p>
                    @endif
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $departement->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $departement->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Statistiques avec affichage du nombre de spécialités -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations supplémentaires</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $departement->specialites->count() }}</div>
                        <div class="text-xs text-slate-500">Spécialités</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $departement->niveaux->count() }}</div>
                        <div class="text-xs text-slate-500">Niveaux</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $departement->matieres->count() }}</div>
                        <div class="text-xs text-slate-500">Matières</div>
                    </div>
                </div>

                <!-- Liste des spécialités du département -->
                @if($departement->specialites->count() > 0)
                    <div class="mt-4">
                        <h5 class="text-sm font-semibold text-slate-600 mb-2">Spécialités du département</h5>
                        <div class="flex flex-wrap gap-2">
                            @foreach($departement->specialites as $specialite)
                                <span class="px-3 py-1 bg-brand-50 text-brand-700 rounded-full text-xs font-medium">
                                    {{ $specialite->libelle }}
                                    <span class="text-brand-400 ml-1">({{ $specialite->code }})</span>
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('departements.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="{{ route('departements.edit', $departement) }}"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            <a href="{{ route('specialites.create') }}?departement_id={{ $departement->id }}"
               class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-emerald-700 transition">
                <i class="fa-solid fa-plus mr-1"></i> Ajouter une spécialité
            </a>
            <form action="{{ route('departements.destroy', $departement) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de ce département ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
            <form action="{{ route('departements.toggle-status', $departement) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="px-4 py-2.5 {{ $departement->est_actif ? 'bg-slate-600' : 'bg-emerald-600' }} text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid {{ $departement->est_actif ? 'fa-pause' : 'fa-play' }} mr-1"></i>
                    {{ $departement->est_actif ? 'Désactiver' : 'Activer' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
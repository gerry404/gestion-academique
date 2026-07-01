{{-- resources/views/inscriptions/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails inscription - EduManager')

@php
    $pageTitle = 'Détails inscription';
    $pageSub = 'Informations complètes de l\'inscription';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">Inscription #{{ $inscription->id }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $inscription->statut === 'validee' ? 'bg-green-100 text-green-700' : 
                               ($inscription->statut === 'annulee' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($inscription->statut) }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ $inscription->etudiant->nom_complet ?? 'N/A' }} • {{ $inscription->etudiant->matricule ?? 'N/A' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('inscriptions.edit', $inscription) }}"
                       class="px-3 py-1.5 bg-amber-100 text-amber-700 rounded-lg text-sm font-semibold hover:bg-amber-200 transition">
                        <i class="fa-solid fa-pen"></i> Modifier
                    </a>
                </div>
            </div>
        </div>

        <!-- Informations -->
        <div class="p-6 space-y-4">
            <div class="grid sm:grid-cols-2 gap-4">
                <!-- Étudiant -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Étudiant</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <a href="{{ route('etudiants.show', $inscription->etudiant) }}" class="text-brand-600 hover:underline">
                            {{ $inscription->etudiant->nom_complet ?? 'N/A' }}
                        </a>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Matricule</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->etudiant->matricule ?? 'N/A' }}</p>
                </div>
                
                <!-- Année académique -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Année académique</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->anneeAcademique->libelle ?? 'N/A' }}</p>
                </div>
                
                <!-- Département -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Département</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->departement->libelle ?? 'N/A' }}</p>
                </div>
                
                <!-- Spécialité -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Spécialité</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->specialite->libelle ?? 'N/A' }}</p>
                </div>
                
                <!-- Niveau -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Niveau</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->niveau->libelle ?? 'N/A' }}</p>
                </div>
                
                <!-- Date d'inscription -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Date d'inscription</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $inscription->date_inscription?->format('d/m/Y H:i') ?? 'N/A' }}</p>
                </div>
                
                <!-- Statut -->
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold 
                            {{ $inscription->statut === 'validee' ? 'bg-green-100 text-green-700' : 
                               ($inscription->statut === 'annulee' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ ucfirst($inscription->statut) }}
                        </span>
                    </p>
                </div>

                <!-- Commentaire -->
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Commentaire</label>
                    <p class="text-slate-800 mt-1">{{ $inscription->commentaire ?? 'Aucun commentaire' }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('inscriptions.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="{{ route('inscriptions.edit', $inscription) }}"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            
            @if($inscription->statut === 'en_attente')
                <form action="{{ route('inscriptions.valider', $inscription) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-emerald-700 transition">
                        <i class="fa-solid fa-check mr-1"></i> Valider
                    </button>
                </form>
                <form action="{{ route('inscriptions.annuler', $inscription) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            onclick="return confirm('Confirmer l'annulation de cette inscription ?')"
                            class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                        <i class="fa-solid fa-xmark mr-1"></i> Annuler
                    </button>
                </form>
            @endif
            
            <form action="{{ route('inscriptions.destroy', $inscription) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de cette inscription ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- resources/views/etablissement/semestres/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails semestre - EduManager')

@php
    $pageTitle = 'Détails semestre';
    $pageSub = 'Informations complètes du semestre';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $semestre->libelle }}</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ $semestre->niveau->libelle ?? '-' }} • {{ $semestre->anneeAcademique->libelle ?? '-' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('semestres.edit', $semestre) }}"
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
                    <p class="text-slate-800 font-medium mt-1">{{ $semestre->libelle }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Niveau</label>
                    <p class="text-slate-800 font-medium mt-1">
                        @if($semestre->niveau)
                            {{ $semestre->niveau->libelle }}
                            <span class="text-xs text-slate-400 block">{{ $semestre->niveau->specialite->libelle ?? '' }}</span>
                        @else
                            <span class="text-slate-400">Non défini</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Année académique</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $semestre->anneeAcademique->libelle ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Matières</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $semestre->matieres->count() }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Liste des matières -->
            @if($semestre->matieres->count() > 0)
                <div class="pt-4 border-t border-slate-100">
                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Matières du semestre</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($semestre->matieres as $matiere)
                            <div class="flex items-center justify-between p-2 bg-slate-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-slate-800">{{ $matiere->libelle }}</span>
                                    <span class="text-xs text-slate-400 block">{{ $matiere->code }}</span>
                                </div>
                                <span class="px-2 py-1 bg-brand-50 text-brand-700 rounded text-xs font-semibold">
                                    {{ $matiere->credit }} crédits
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="pt-4 border-t border-slate-100 text-center text-slate-500">
                    <i class="fa-solid fa-book text-3xl text-slate-300 mb-2 block"></i>
                    Aucune matière associée à ce semestre
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('semestres.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="{{ route('semestres.edit', $semestre) }}"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            <form action="{{ route('semestres.destroy', $semestre) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de ce semestre ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- resources/views/etablissement/matieres/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails matière - EduManager')

@php
    $pageTitle = 'Détails matière';
    $pageSub = 'Informations complètes de la matière';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- En-tête -->
        <div class="p-6 border-b border-slate-100">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-slate-800">{{ $matiere->libelle }}</h3>
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $matiere->code }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mt-1">
                        {{ $matiere->uniteEnseignement->libelle ?? '-' }} • {{ $matiere->semestre->libelle ?? '-' }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('matieres.edit', $matiere) }}"
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
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->code }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Libellé</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->libelle }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Crédits</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $matiere->credit }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</label>
                    <p class="text-slate-800 font-medium mt-1">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $matiere->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $matiere->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Département</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->departement->libelle ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">UE</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->uniteEnseignement->libelle ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Semestre</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->semestre->libelle ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Niveau</label>
                    <p class="text-slate-800 font-medium mt-1">{{ $matiere->niveau->libelle ?? '-' }}</p>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Enseignant</label>
                    <p class="text-slate-800 font-medium mt-1">
                        @if($matiere->personnel)
                            {{ $matiere->personnel->nom_complet }}
                            <span class="text-sm text-slate-500 block">{{ $matiere->personnel->matricule }}</span>
                        @else
                            <span class="text-slate-400">Non assigné</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Informations UE -->
            <div class="pt-4 border-t border-slate-100">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Informations de l'UE</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <div class="text-xs text-slate-500">Total crédits UE</div>
                        <div class="text-lg font-bold text-brand-600">{{ $matiere->uniteEnseignement->total_credit ?? 0 }}</div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <div class="text-xs text-slate-500">Somme crédits matières</div>
                        <div class="text-lg font-bold text-brand-600">
                            {{ \App\Models\Etablissement\Matiere::where('unite_enseignement_id', $matiere->unite_enseignement_id)->sum('credit') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-wrap gap-2">
            <a href="{{ route('matieres.index') }}"
               class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                <i class="fa-solid fa-arrow-left mr-1"></i> Retour
            </a>
            <a href="{{ route('matieres.edit', $matiere) }}"
               class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                <i class="fa-solid fa-pen mr-1"></i> Modifier
            </a>
            <form action="{{ route('matieres.destroy', $matiere) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Confirmer la suppression de cette matière ?')"
                        class="px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-red-700 transition">
                    <i class="fa-solid fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
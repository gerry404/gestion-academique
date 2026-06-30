{{-- resources/views/etablissement/matieres/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Matières - EduManager')

@php
    $pageTitle = 'Matières';
    $pageSub = 'Gestion des matières par UE et semestre';
@endphp

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="flex flex-wrap gap-2 flex-1">
        <div class="relative max-w-sm flex-1 min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <form method="GET" action="{{ route('matieres.index') }}" class="inline">
                <input type="text" name="search" placeholder="Rechercher une matière..."
                       value="{{ request('search') }}"
                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('matieres.index') }}" class="inline">
                <select name="unite_enseignement_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les UE</option>
                    @foreach($ues as $ue)
                        <option value="{{ $ue->id }}" {{ request('unite_enseignement_id') == $ue->id ? 'selected' : '' }}>
                            {{ $ue->libelle }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('matieres.index') }}" class="inline">
                <select name="semestre_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Tous les semestres</option>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>
                            {{ $semestre->libelle }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <button onclick="toast('Export Excel lancé', 'info')"
                class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="{{ route('matieres.create') }}"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouvelle matière
        </a>
    </div>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-700 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-500"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-red-500"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Code</th>
                    <th class="px-4 py-3 text-left font-semibold">Libellé</th>
                    <th class="px-4 py-3 text-left font-semibold">Crédits</th>
                    <th class="px-4 py-3 text-left font-semibold">UE</th>
                    <th class="px-4 py-3 text-left font-semibold">Semestre</th>
                    <th class="px-4 py-3 text-left font-semibold">Niveau</th>
                    <th class="px-4 py-3 text-left font-semibold">Enseignant</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($matieres as $matiere)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700">{{ $matiere->code }}</td>
                    <td class="px-4 py-3">{{ $matiere->libelle }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-semibold">
                            {{ $matiere->credit }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $matiere->uniteEnseignement->libelle ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $matiere->semestre->libelle ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $matiere->niveau->libelle ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $matiere->personnel->nom_complet ?? 'Non assigné' }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('matieres.show', $matiere) }}"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('matieres.edit', $matiere) }}"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('matieres.destroy', $matiere) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de cette matière ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition"
                                    title="Supprimer">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-book text-4xl text-slate-300 mb-2 block"></i>
                        Aucune matière trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $matieres->links() }}
</div>
@endsection
{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Liste des notes - EduManager')

@php
    $pageTitle = 'Liste des notes';
    $pageSub = 'Gestion des notes des étudiants';
@endphp

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="flex flex-wrap gap-2 flex-1">
        <div class="relative max-w-sm flex-1 min-w-[200px]">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <form method="GET" action="{{ route('notes.index') }}" class="inline">
                <input type="text" name="search" placeholder="Rechercher..."
                       value="{{ request('search') }}"
                       class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('notes.index') }}" class="inline">
                <select name="annee_academique_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les années</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" {{ request('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="relative">
            <form method="GET" action="{{ route('notes.index') }}" class="inline">
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
        <div class="relative">
            <form method="GET" action="{{ route('notes.index') }}" class="inline">
                <select name="matiere_id" onchange="this.form.submit()"
                        class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-brand-200 outline-none transition">
                    <option value="">Toutes les matières</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->libelle }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <a href="{{ route('notes.create') }}"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouvelle note
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
                    <th class="px-4 py-3 text-left font-semibold">#</th>
                    <th class="px-4 py-3 text-left font-semibold">Étudiant</th>
                    <th class="px-4 py-3 text-left font-semibold">Matière</th>
                    <th class="px-4 py-3 text-left font-semibold">CC</th>
                    <th class="px-4 py-3 text-left font-semibold">Examen</th>
                    <th class="px-4 py-3 text-left font-semibold">Moyenne</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($notes as $note)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3">#{{ $note->id }}</td>
                    <td class="px-4 py-3">{{ $note->etudiant->nom_complet ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $note->matiere->libelle ?? '-' }}</td>
                    <td class="px-4 py-3">{{ number_format($note->note_cc, 2) }}</td>
                    <td class="px-4 py-3">{{ number_format($note->note_examen, 2) }}</td>
                    <td class="px-4 py-3 font-bold {{ $note->est_valide ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($note->moyenne, 2) }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $note->est_valide ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $note->est_valide ? 'Validé' : 'Non validé' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('notes.show', $note) }}"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('notes.edit', $note) }}"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de cette note ?')"
                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 inline-flex items-center justify-center ml-1 transition">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-slate-500">
                        <i class="fa-solid fa-pen-to-square text-4xl text-slate-300 mb-2 block"></i>
                        Aucune note trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $notes->links() }}</div>
@endsection
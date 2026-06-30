{{-- resources/views/etablissement/personnels/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Personnel - EduManager')

@php
    $pageTitle = 'Personnel';
    $pageSub = 'Gestion des employés de l\'établissement';
@endphp

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
    <div class="relative max-w-sm flex-1">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <form method="GET" action="{{ route('personnels.index') }}" class="inline">
            <input type="text" name="search" placeholder="Rechercher un employé..."
                   value="{{ request('search') }}"
                   class="w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-200 outline-none transition"/>
        </form>
    </div>
    <div class="flex gap-2 flex-wrap">
      
        <button onclick="toast('Export Excel lancé', 'info')"
                class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
            <i class="fa-solid fa-file-excel text-green-600"></i> Excel
        </button>
        <a href="{{ route('personnels.create') }}"
           class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
            <i class="fa-solid fa-plus mr-1"></i> Nouvel employé
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
                    <th class="px-4 py-3 text-left font-semibold">Matricule</th>
                    <th class="px-4 py-3 text-left font-semibold">Nom complet</th>
                    <th class="px-4 py-3 text-left font-semibold">Fonction</th>
                    <th class="px-4 py-3 text-left font-semibold">Email</th>
                    <th class="px-4 py-3 text-left font-semibold">Téléphone</th>
                    <th class="px-4 py-3 text-left font-semibold">Compte</th>
                    <th class="px-4 py-3 text-left font-semibold">Statut</th>
                    <th class="px-4 py-3 text-right font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($personnels as $personnel)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700">{{ $personnel->matricule }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full {{ $personnel->sexe === 'F' ? 'bg-pink-500' : 'bg-brand-600' }} text-white flex items-center justify-center text-xs font-semibold">
                                {{ strtoupper(substr($personnel->prenom, 0, 1)) }}{{ strtoupper(substr($personnel->nom, 0, 1)) }}
                            </div>
                            <span class="font-medium">{{ $personnel->prenom }} {{ $personnel->nom }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">{{ $personnel->fonction }}</td>
                    <td class="px-4 py-3">{{ $personnel->email ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $personnel->telephone ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($personnel->user_id)
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <i class="fa-solid fa-check-circle"></i> Oui
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                <i class="fa-solid fa-circle-xmark"></i> Non
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $personnel->est_actif ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $personnel->est_actif ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('personnels.show', $personnel) }}"
                           class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 hover:bg-sky-200 inline-flex items-center justify-center ml-1 transition"
                           title="Voir">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <a href="{{ route('personnels.edit', $personnel) }}"
                           class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 inline-flex items-center justify-center ml-1 transition"
                           title="Modifier">
                            <i class="fa-solid fa-pen text-xs"></i>
                        </a>
                        <form action="{{ route('personnels.toggle-status', $personnel) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-8 h-8 rounded-lg {{ $personnel->est_actif ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-green-100 text-green-600 hover:bg-green-200' }} inline-flex items-center justify-center ml-1 transition"
                                    title="{{ $personnel->est_actif ? 'Désactiver' : 'Activer' }}">
                                <i class="fa-solid {{ $personnel->est_actif ? 'fa-pause' : 'fa-play' }} text-xs"></i>
                            </button>
                        </form>
                        <form action="{{ route('personnels.destroy', $personnel) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Confirmer la suppression de cet employé ?')"
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
                        <i class="fa-solid fa-user-tie text-4xl text-slate-300 mb-2 block"></i>
                        Aucun employé trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $personnels->links() }}
</div>
@endsection
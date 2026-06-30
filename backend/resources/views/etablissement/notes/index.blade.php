{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Notes - EduManager')

@php
    $pageTitle = 'Gestion des notes';
    $pageSub = 'Saisie et gestion des notes des étudiants';
@endphp

@section('content')
<div class="flex flex-wrap gap-3 mb-5">
    <select class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
        <option>Matière: Algorithmique avancée</option>
        <option>SQL & Modélisation</option>
        <option>Réseaux TCP/IP</option>
    </select>
    <select class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
        <option>Semestre: S3</option>
        <option>S4</option>
        <option>S5</option>
    </select>
    <select class="px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm">
        <option>Session: Normale</option>
        <option>Rattrapage</option>
    </select>
    <div class="flex-1"></div>
    <button onclick="toast('Notes enregistrées', 'success')" class="px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold shadow hover:bg-emerald-700 transition">
        <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
    </button>
    <button onclick="toast('Notes transférées à l\'administration', 'success')" class="px-4 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
        <i class="fa-solid fa-paper-plane mr-1"></i> Transférer
    </button>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto scrollbar-thin">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Matricule</th>
                    <th class="px-4 py-3 text-left">Nom complet</th>
                    <th class="px-4 py-3 text-left">Matière</th>
                    <th class="px-4 py-3">Crédit</th>
                    <th class="px-4 py-3">CC (30%)</th>
                    <th class="px-4 py-3">Examen (70%)</th>
                    <th class="px-4 py-3">Moyenne</th>
                    <th class="px-4 py-3">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($notes as $note)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 py-3 font-bold text-brand-700">{{ $note->matricule }}</td>
                    <td class="px-4 py-3">{{ $note->nom_complet }}</td>
                    <td class="px-4 py-3">{{ $note->matiere }}</td>
                    <td class="px-4 py-3 text-center">{{ $note->credit }}</td>
                    <td class="px-4 py-3">
                        <input type="number" value="{{ $note->cc }}" min="0" max="20" 
                               class="w-16 px-2 py-1 border border-slate-200 rounded text-center focus:ring-2 focus:ring-brand-200 outline-none"/>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" value="{{ $note->examen }}" min="0" max="20" 
                               class="w-16 px-2 py-1 border border-slate-200 rounded text-center focus:ring-2 focus:ring-brand-200 outline-none"/>
                    </td>
                    <td class="px-4 py-3 text-center font-bold {{ $note->moyenne >= 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($note->moyenne, 2) }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $note->moyenne >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $note->moyenne >= 10 ? 'Validé' : 'Non validé' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500">
                        <i class="fa-solid fa-pen-to-square text-4xl text-slate-300 mb-2 block"></i>
                        Aucune note saisie pour cette matière
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 p-4 bg-brand-50 border border-brand-100 rounded-xl text-sm text-brand-800">
    <i class="fa-solid fa-calculator"></i> 
    <b>Formule :</b> Moyenne = (CC × 30%) + (Examen × 70%) — Validation si moyenne ≥ 10/20
</div>
@endsection
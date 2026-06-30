{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Tableau de bord - EduManager')

@php
    $pageTitle = 'Tableau de bord';
    $pageSub = 'Vue d\'ensemble de votre établissement';
@endphp

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Étudiants</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['etudiants'] ?? '2 547' }}</p>
                <p class="text-xs mt-2 text-green-600 font-semibold">
                    <i class="fa-solid fa-arrow-trend-up"></i> +12% ce mois
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl grad-blue flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-user-graduate"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Enseignants</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['enseignants'] ?? '128' }}</p>
                <p class="text-xs mt-2 text-green-600 font-semibold">
                    <i class="fa-solid fa-arrow-trend-up"></i> +3% ce mois
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Départements</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['departements'] ?? '12' }}</p>
                <p class="text-xs mt-2 text-slate-500 font-semibold">
                    <i class="fa-solid fa-minus"></i> Stable
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-sky-500 to-sky-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-building-columns"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 card-hover border border-slate-100">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider text-slate-500 font-semibold">Taux réussite</p>
                <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['taux_reussite'] ?? '87%' }}</p>
                <p class="text-xs mt-2 text-green-600 font-semibold">
                    <i class="fa-solid fa-arrow-trend-up"></i> +4% ce mois
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-white text-xl shadow-lg">
                <i class="fa-solid fa-check-double"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-5">
    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Actions rapides</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-user-plus text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Inscrire étudiant</p>
            </a>
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-pen-to-square text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Saisir notes</p>
            </a>
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-file-pdf text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Générer relevé</p>
            </a>
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-id-card text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Imprimer carte</p>
            </a>
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-chart-pie text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Voir stats</p>
            </a>
            <a href="#" class="p-4 bg-brand-50 hover:bg-brand-100 rounded-xl text-center transition group">
                <i class="fa-solid fa-user-shield text-brand-600 text-xl group-hover:scale-110 transition inline-block"></i>
                <p class="text-xs font-semibold text-slate-700 mt-2">Créer utilisateur</p>
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100">
        <h3 class="font-bold text-slate-800 mb-4">Dernières activités</h3>
        <ul class="space-y-3 text-sm">
            <li class="flex gap-3 items-start">
                <div class="w-9 h-9 rounded-lg bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-700">Nouvelle inscription : Foning Carine</p>
                    <p class="text-xs text-slate-400">Il y a 5 min</p>
                </div>
            </li>
            <li class="flex gap-3 items-start">
                <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-file-circle-check"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-700">Relevé de notes généré pour 2024GI002</p>
                    <p class="text-xs text-slate-400">Il y a 1h</p>
                </div>
            </li>
            <li class="flex gap-3 items-start">
                <div class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-slate-700">3 enseignants n'ont pas encore saisi leurs notes</p>
                    <p class="text-xs text-slate-400">Hier</p>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
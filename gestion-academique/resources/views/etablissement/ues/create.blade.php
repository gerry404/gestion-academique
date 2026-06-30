{{-- resources/views/etablissement/ues/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouvelle UE - EduManager')

@php
    $pageTitle = 'Nouvelle unité d\'enseignement';
    $pageSub = 'Ajouter une UE à un niveau';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                    <div>
                        <p class="font-semibold mb-1">Veuillez corriger les erreurs suivantes :</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('ues.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique *</label>
                <select name="annee_academique_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('annee_academique_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner une année</option>
                    @foreach($anneesAcademiques as $annee)
                        <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }}
                        </option>
                    @endforeach
                </select>
                @error('annee_academique_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('niveau_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un niveau</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->display_full }}
                        </option>
                    @endforeach
                </select>
                @error('niveau_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">
                    <i class="fa-solid fa-info-circle"></i> Exemple: L1 - Génie Logiciel (Informatique)
                </p>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Code *</label>
                    <input type="text" name="code" value="{{ old('code') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('code') border-red-500 @enderror"
                           placeholder="Ex: UE-INF-101" required>
                    @error('code')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Total crédits *</label>
                    <input type="number" name="total_credit" value="{{ old('total_credit') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('total_credit') border-red-500 @enderror"
                           placeholder="Ex: 6" min="1" max="60" required>
                    @error('total_credit')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle') }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: Programmation Web">
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Position sur le relevé</label>
                <input type="number" name="position_releve" value="{{ old('position_releve') }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('position_releve') border-red-500 @enderror"
                       placeholder="Ex: 1" min="1">
                @error('position_releve')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">
                    <i class="fa-solid fa-info-circle"></i> Ordre d'affichage sur le relevé de notes
                </p>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('ues.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
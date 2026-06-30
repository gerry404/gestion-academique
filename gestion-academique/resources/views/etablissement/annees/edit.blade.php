{{-- resources/views/etablissement/annees/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier année académique - EduManager')

@php
    $pageTitle = 'Modifier année académique';
    $pageSub = 'Mettre à jour les informations de l\'année';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('annees-academiques.update', $anneeAcademique) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle', $anneeAcademique->libelle) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: 2025-2026" required>
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date début *</label>
                    <input type="date" name="date_debut" value="{{ old('date_debut', $anneeAcademique->date_debut?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('date_debut') border-red-500 @enderror"
                           required>
                    @error('date_debut')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date fin *</label>
                    <input type="date" name="date_fin" value="{{ old('date_fin', $anneeAcademique->date_fin?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('date_fin') border-red-500 @enderror"
                           required>
                    @error('date_fin')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Note de validation</label>
                <input type="number" name="note_validation" value="{{ old('note_validation', $anneeAcademique->note_validation) }}" step="0.5" min="0" max="20"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('note_validation') border-red-500 @enderror"
                       placeholder="10">
                @error('note_validation')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('description') border-red-500 @enderror"
                          placeholder="Description de l'année académique...">{{ old('description', $anneeAcademique->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_active" value="1"
                           {{ old('est_active', $anneeAcademique->est_active) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Année active</span>
                </label>
                @if($anneeAcademique->est_active)
                    <p class="text-xs text-amber-600 mt-1">
                        <i class="fa-solid fa-info-circle"></i>
                        Cette année est actuellement active.
                    </p>
                @endif
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('annees-academiques.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
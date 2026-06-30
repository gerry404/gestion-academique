{{-- resources/views/etablissement/departements/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouveau département - EduManager')

@php
    $pageTitle = 'Nouveau département';
    $pageSub = 'Ajouter un département à votre établissement';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('departements.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Code *</label>
                <input 
                    type="text" 
                    name="code" 
                    value="{{ old('code') }}"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('code') border-red-500 @enderror"
                    placeholder="Ex: INFO"
                    required
                />
                @error('code')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input 
                    type="text" 
                    name="libelle" 
                    value="{{ old('libelle') }}"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                    placeholder="Ex: Département Informatique"
                    required
                />
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Description</label>
                <textarea 
                    name="description" 
                    rows="3"
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('description') border-red-500 @enderror"
                    placeholder="Description du département..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Chef de département</label>
                <select 
                    name="chef_departement_id" 
                    class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('chef_departement_id') border-red-500 @enderror"
                >
                    <option value="">Sélectionner un chef</option>
                    @foreach($personnels as $personnel)
                        <option value="{{ $personnel->id }}" {{ old('chef_departement_id') == $personnel->id ? 'selected' : '' }}>
                            {{ $personnel->nom_complet }} ({{ $personnel->matricule }})
                        </option>
                    @endforeach
                </select>
                @error('chef_departement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input 
                        type="checkbox" 
                        name="est_actif" 
                        value="1" 
                        {{ old('est_actif', true) ? 'checked' : '' }}
                        class="accent-brand-600 rounded"
                    />
                    <span class="text-slate-600">Actif</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('departements.index') }}" class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button type="submit" class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
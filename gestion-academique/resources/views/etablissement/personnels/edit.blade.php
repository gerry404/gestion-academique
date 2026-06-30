{{-- resources/views/etablissement/personnels/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier employé - EduManager')

@php
    $pageTitle = 'Modifier employé';
    $pageSub = 'Mettre à jour les informations du personnel';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('personnels.update', $personnel) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Matricule *</label>
                    <input type="text" name="matricule" value="{{ old('matricule', $personnel->matricule) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('matricule') border-red-500 @enderror"
                           placeholder="Ex: EMP001" required>
                    @error('matricule')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Sexe *</label>
                    <select name="sexe" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('sexe') border-red-500 @enderror" required>
                        <option value="">Sélectionner</option>
                        <option value="M" {{ old('sexe', $personnel->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe', $personnel->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sexe')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $personnel->nom) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('nom') border-red-500 @enderror"
                           placeholder="Dupont" required>
                    @error('nom')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $personnel->prenom) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('prenom') border-red-500 @enderror"
                           placeholder="Jean" required>
                    @error('prenom')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Fonction *</label>
                <input type="text" name="fonction" value="{{ old('fonction', $personnel->fonction) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('fonction') border-red-500 @enderror"
                       placeholder="Directeur, Secrétaire, Enseignant..." required>
                @error('fonction')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email', $personnel->email) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('email') border-red-500 @enderror"
                           placeholder="jean.dupont@edu.cm">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $personnel->telephone) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('telephone') border-red-500 @enderror"
                           placeholder="+237 6XX XX XX XX">
                    @error('telephone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Adresse</label>
                <input type="text" name="adresse" value="{{ old('adresse', $personnel->adresse) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('adresse') border-red-500 @enderror"
                       placeholder="Yaoundé, Cameroun">
                @error('adresse')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance', $personnel->date_naissance?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('date_naissance') border-red-500 @enderror">
                    @error('date_naissance')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $personnel->lieu_naissance) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('lieu_naissance') border-red-500 @enderror"
                           placeholder="Yaoundé">
                    @error('lieu_naissance')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Diplôme</label>
                    <input type="text" name="diplome" value="{{ old('diplome', $personnel->diplome) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('diplome') border-red-500 @enderror"
                           placeholder="Master en Informatique">
                    @error('diplome')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date d'embauche</label>
                    <input type="date" name="date_embauche" value="{{ old('date_embauche', $personnel->date_embauche?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('date_embauche') border-red-500 @enderror">
                    @error('date_embauche')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           {{ old('est_actif', $personnel->est_actif) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Employé actif</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('personnels.index') }}"
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
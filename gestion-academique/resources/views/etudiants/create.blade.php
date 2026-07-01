{{-- resources/views/etudiants/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ajouter un étudiant - EduManager')

@php
    $pageTitle = 'Ajouter un étudiant';
    $pageSub = 'Enregistrer un nouvel étudiant';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('etudiants.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nom et Prénom -->
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('nom') border-red-500 @enderror"
                           required>
                    @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('prenom') border-red-500 @enderror"
                           required>
                    @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Sexe et Nationalité -->
            <div class="grid sm:grid-cols-3 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Sexe *</label>
                    <select name="sexe"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('sexe') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner</option>
                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sexe') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nationalité</label>
                    <input type="text" name="nationalite" value="{{ old('nationalite') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Pays *</label>
                    <select name="pays"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('pays') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner un pays</option>
                        <option value="Cameroun" {{ old('pays') == 'Cameroun' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
                        <option value="Nigeria" {{ old('pays') == 'Nigeria' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
                        <option value="Sénégal" {{ old('pays') == 'Sénégal' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
                        <option value="Côte d'Ivoire" {{ old('pays') == "Côte d'Ivoire" ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
                        <option value="Ghana" {{ old('pays') == 'Ghana' ? 'selected' : '' }}>🇬🇭 Ghana</option>
                        <option value="Kenya" {{ old('pays') == 'Kenya' ? 'selected' : '' }}>🇰🇪 Kenya</option>
                        <option value="Afrique du Sud" {{ old('pays') == 'Afrique du Sud' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
                        <option value="Maroc" {{ old('pays') == 'Maroc' ? 'selected' : '' }}>🇲🇦 Maroc</option>
                        <option value="Tunisie" {{ old('pays') == 'Tunisie' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
                        <option value="Algérie" {{ old('pays') == 'Algérie' ? 'selected' : '' }}>🇩🇿 Algérie</option>
                        <option value="Égypte" {{ old('pays') == 'Égypte' ? 'selected' : '' }}>🇪🇬 Égypte</option>
                        <option value="République Démocratique du Congo" {{ old('pays') == 'République Démocratique du Congo' ? 'selected' : '' }}>🇨🇩 RDC</option>
                        <option value="Angola" {{ old('pays') == 'Angola' ? 'selected' : '' }}>🇦🇴 Angola</option>
                        <option value="Mali" {{ old('pays') == 'Mali' ? 'selected' : '' }}>🇲🇱 Mali</option>
                        <option value="Burkina Faso" {{ old('pays') == 'Burkina Faso' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
                    </select>
                    @error('pays') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Date et Lieu de naissance -->
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <!-- Email et Téléphone -->
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <!-- Adresse -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Adresse</label>
                <textarea name="adresse" rows="2"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">{{ old('adresse') }}</textarea>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('etudiants.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
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
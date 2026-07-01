{{-- resources/views/etudiants/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier étudiant - EduManager')

@php
    $pageTitle = 'Modifier étudiant';
    $pageSub = 'Mettre à jour les informations de l\'étudiant';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        <form action="{{ route('etudiants.update', $etudiant) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nom *</label>
                    <input type="text" name="nom" value="{{ old('nom', $etudiant->nom) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('nom') border-red-500 @enderror"
                           required>
                    @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Prénom *</label>
                    <input type="text" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('prenom') border-red-500 @enderror"
                           required>
                    @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Sexe *</label>
                    <select name="sexe"
                            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('sexe') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionner</option>
                        <option value="M" {{ old('sexe', $etudiant->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe', $etudiant->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sexe') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Nationalité</label>
                    <input type="text" name="nationalite" value="{{ old('nationalite', $etudiant->nationalite) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
        <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Pays *</label>
        <select name="pays"
                class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('pays') border-red-500 @enderror"
                required>
            <option value="">Sélectionner un pays</option>
            <option value="Cameroun" {{ old('pays', $etudiant->pays) == 'Cameroun' ? 'selected' : '' }}>🇨🇲 Cameroun</option>
            <option value="Nigeria" {{ old('pays', $etudiant->pays) == 'Nigeria' ? 'selected' : '' }}>🇳🇬 Nigeria</option>
            <option value="Sénégal" {{ old('pays', $etudiant->pays) == 'Sénégal' ? 'selected' : '' }}>🇸🇳 Sénégal</option>
            <option value="Côte d'Ivoire" {{ old('pays', $etudiant->pays) == "Côte d'Ivoire" ? 'selected' : '' }}>🇨🇮 Côte d'Ivoire</option>
            <option value="Ghana" {{ old('pays', $etudiant->pays) == 'Ghana' ? 'selected' : '' }}>🇬🇭 Ghana</option>
            <option value="Kenya" {{ old('pays', $etudiant->pays) == 'Kenya' ? 'selected' : '' }}>🇰🇪 Kenya</option>
            <option value="Afrique du Sud" {{ old('pays', $etudiant->pays) == 'Afrique du Sud' ? 'selected' : '' }}>🇿🇦 Afrique du Sud</option>
            <option value="Maroc" {{ old('pays', $etudiant->pays) == 'Maroc' ? 'selected' : '' }}>🇲🇦 Maroc</option>
            <option value="Tunisie" {{ old('pays', $etudiant->pays) == 'Tunisie' ? 'selected' : '' }}>🇹🇳 Tunisie</option>
            <option value="Algérie" {{ old('pays', $etudiant->pays) == 'Algérie' ? 'selected' : '' }}>🇩🇿 Algérie</option>
            <option value="Égypte" {{ old('pays', $etudiant->pays) == 'Égypte' ? 'selected' : '' }}>🇪🇬 Égypte</option>
            <option value="République Démocratique du Congo" {{ old('pays', $etudiant->pays) == 'République Démocratique du Congo' ? 'selected' : '' }}>🇨🇩 RDC</option>
            <option value="Angola" {{ old('pays', $etudiant->pays) == 'Angola' ? 'selected' : '' }}>🇦🇴 Angola</option>
            <option value="Mali" {{ old('pays', $etudiant->pays) == 'Mali' ? 'selected' : '' }}>🇲🇱 Mali</option>
            <option value="Burkina Faso" {{ old('pays', $etudiant->pays) == 'Burkina Faso' ? 'selected' : '' }}>🇧🇫 Burkina Faso</option>
        </select>
        @error('pays')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Date de naissance</label>
                    <input type="date" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance?->format('Y-m-d')) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Lieu de naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $etudiant->lieu_naissance) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Email</label>
                    <input type="email" name="email" value="{{ old('email', $etudiant->email) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Téléphone</label>
                    <input type="text" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">
                </div>
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Adresse</label>
                <textarea name="adresse" rows="2"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition">{{ old('adresse', $etudiant->adresse) }}</textarea>
            </div>

            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           {{ old('est_actif', $etudiant->est_actif) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Étudiant actif</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('etudiants.index') }}"
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
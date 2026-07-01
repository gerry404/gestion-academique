{{-- resources/views/inscriptions/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouvelle inscription - EduManager')

@php
    $pageTitle = 'Nouvelle inscription';
    $pageSub = 'Inscrire un étudiant dans une filière';
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

        <form action="{{ route('inscriptions.store') }}" method="POST" class="space-y-4" id="inscriptionForm">
            @csrf

            <!-- Étudiant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Étudiant *</label>
                <select name="etudiant_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('etudiant_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un étudiant</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}" {{ old('etudiant_id', request('etudiant_id')) == $etudiant->id ? 'selected' : '' }}>
                            {{ $etudiant->nom_complet }} ({{ $etudiant->matricule }})
                        </option>
                    @endforeach
                </select>
                @error('etudiant_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Année académique -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique *</label>
                <select name="annee_academique_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('annee_academique_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner une année</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" {{ old('annee_academique_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }} {{ $annee->est_active ? '(Active)' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('annee_academique_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Département -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('departement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ old('departement_id') == $departement->id ? 'selected' : '' }}>
                            {{ $departement->libelle }} ({{ $departement->code }})
                        </option>
                    @endforeach
                </select>
                @error('departement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Spécialité (dynamique selon département) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                <select name="specialite_id" id="specialite_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('specialite_id') border-red-500 @enderror"
                        required disabled>
                    <option value="">Sélectionner d'abord un département</option>
                </select>
                @error('specialite_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Niveau (dynamique selon spécialité) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('niveau_id') border-red-500 @enderror"
                        required disabled>
                    <option value="">Sélectionner d'abord une spécialité</option>
                </select>
                @error('niveau_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Commentaire -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Commentaire</label>
                <textarea name="commentaire" rows="3"
                          class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('commentaire') border-red-500 @enderror"
                          placeholder="Informations supplémentaires sur l'inscription...">{{ old('commentaire') }}</textarea>
                @error('commentaire')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('inscriptions.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer l'inscription
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departementSelect = document.getElementById('departement_select');
    const specialiteSelect = document.getElementById('specialite_select');
    const niveauSelect = document.getElementById('niveau_select');

    // ============================================
    // 1. Charger les spécialités par département
    // ============================================
    function loadSpecialites(departementId, selectedId = null) {
        if (departementId) {
            specialiteSelect.disabled = false;
            specialiteSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-specialites-by-departement?departement_id=${departementId}`)
                .then(response => response.json())
                .then(data => {
                    specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
                    // Réinitialiser le niveau
                    niveauSelect.disabled = true;
                    niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
                    
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucune spécialité disponible';
                        option.disabled = true;
                        specialiteSelect.appendChild(option);
                    } else {
                        data.forEach(specialite => {
                            const option = document.createElement('option');
                            option.value = specialite.id;
                            option.textContent = specialite.libelle + ' (' + specialite.code + ')';
                            if (selectedId && specialite.id == selectedId) {
                                option.selected = true;
                                // Charger les niveaux si une spécialité est pré-sélectionnée
                                loadNiveaux(specialite.id, "{{ old('niveau_id') }}");
                            }
                            specialiteSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    specialiteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des spécialités', 'error');
                });
        } else {
            specialiteSelect.disabled = true;
            specialiteSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    }

    // ============================================
    // 2. Charger les niveaux par spécialité
    // ============================================
    function loadNiveaux(specialiteId, selectedId = null) {
        if (specialiteId) {
            niveauSelect.disabled = false;
            niveauSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-niveaux-by-specialite?specialite_id=${specialiteId}`)
                .then(response => response.json())
                .then(data => {
                    niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                    if (data.length === 0) {
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Aucun niveau disponible';
                        option.disabled = true;
                        niveauSelect.appendChild(option);
                    } else {
                        data.forEach(niveau => {
                            const option = document.createElement('option');
                            option.value = niveau.id;
                            option.textContent = niveau.libelle;
                            if (selectedId && niveau.id == selectedId) {
                                option.selected = true;
                            }
                            niveauSelect.appendChild(option);
                        });
                    }
                })
                .catch(() => {
                    niveauSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des niveaux', 'error');
                });
        } else {
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    }

    // ============================================
    // 3. Événements
    // ============================================
    
    // Quand le département change
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        loadSpecialites(departementId);
    });

    // Quand la spécialité change
    specialiteSelect.addEventListener('change', function() {
        const specialiteId = this.value;
        loadNiveaux(specialiteId);
    });

    // ============================================
    // 4. Charger les données initiales
    // ============================================
    const initialDepartement = departementSelect.value;
    const initialSpecialite = "{{ old('specialite_id') }}";
    const initialNiveau = "{{ old('niveau_id') }}";

    if (initialDepartement) {
        loadSpecialites(initialDepartement, initialSpecialite);
    }

   
});
</script>
@endpush
@endsection
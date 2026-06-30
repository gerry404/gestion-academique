{{-- resources/views/etablissement/matieres/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier matière - EduManager')

@php
    $pageTitle = 'Modifier matière';
    $pageSub = 'Mettre à jour les informations de la matière';
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

        <form action="{{ route('matieres.update', $matiere) }}" method="POST" class="space-y-4" id="matiereForm">
            @csrf
            @method('PUT')

            <!-- Département -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('departement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ old('departement_id', $matiere->departement_id) == $departement->id ? 'selected' : '' }}>
                            {{ $departement->libelle }} ({{ $departement->code }})
                        </option>
                    @endforeach
                </select>
                @error('departement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Niveau -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('niveau_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un niveau</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ old('niveau_id', $matiere->niveau_id) == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->display_name }}
                        </option>
                    @endforeach
                </select>
                @error('niveau_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Semestre -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('semestre_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un semestre</option>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}" {{ old('semestre_id', $matiere->semestre_id) == $semestre->id ? 'selected' : '' }}>
                            {{ $semestre->libelle }}
                        </option>
                    @endforeach
                </select>
                @error('semestre_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- UE -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Unité d'enseignement *</label>
                <select name="unite_enseignement_id" id="ue_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('unite_enseignement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner une UE</option>
                    @foreach($ues as $ue)
                        <option value="{{ $ue->id }}" {{ old('unite_enseignement_id', $matiere->unite_enseignement_id) == $ue->id ? 'selected' : '' }}>
                            {{ $ue->libelle }} ({{ $ue->total_credit }} crédits) - {{ $ue->niveau->libelle ?? '' }}
                        </option>
                    @endforeach
                </select>
                @error('unite_enseignement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Enseignant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Enseignant</label>
                <select name="personnel_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('personnel_id') border-red-500 @enderror">
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($personnels as $personnel)
                        <option value="{{ $personnel->id }}" {{ old('personnel_id', $matiere->personnel_id) == $personnel->id ? 'selected' : '' }}>
                            {{ $personnel->nom_complet }} ({{ $personnel->matricule }})
                        </option>
                    @endforeach
                </select>
                @error('personnel_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Code et Crédits -->
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Code *</label>
                    <input type="text" name="code" value="{{ old('code', $matiere->code) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('code') border-red-500 @enderror"
                           placeholder="Ex: INF-101" required>
                    @error('code')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Crédits *</label>
                    <input type="number" name="credit" id="credit_input" value="{{ old('credit', $matiere->credit) }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('credit') border-red-500 @enderror"
                           placeholder="Ex: 3" min="1" max="60" required>
                    @error('credit')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-slate-400 mt-1" id="credit_validation_message"></p>
                </div>
            </div>

            <!-- Libellé -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle', $matiere->libelle) }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: Programmation Web" required>
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut -->
            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           {{ old('est_actif', $matiere->est_actif) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Matière active</span>
                </label>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('matieres.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departementSelect = document.getElementById('departement_select');
    const niveauSelect = document.getElementById('niveau_select');
    const semestreSelect = document.getElementById('semestre_select');
    const ueSelect = document.getElementById('ue_select');

    // Fonction pour charger les niveaux par département (pour edit)
    function loadNiveauxByDepartement(departementId, selectedId) {
        if (departementId) {
            fetch(`/get-niveaux-by-departement?departement_id=${departementId}`)
                .then(response => response.json())
                .then(data => {
                    niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                    data.forEach(niveau => {
                        const option = document.createElement('option');
                        option.value = niveau.id;
                        option.textContent = niveau.display_name;
                        if (selectedId && niveau.id == selectedId) {
                            option.selected = true;
                        }
                        niveauSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    toast('Erreur lors du chargement des niveaux', 'error');
                });
        }
    }

    // Fonction pour charger les semestres par niveau
    function loadSemestresByNiveau(niveauId, selectedId) {
        if (niveauId) {
            fetch(`/get-semestres-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>';
                    data.forEach(semestre => {
                        const option = document.createElement('option');
                        option.value = semestre.id;
                        option.textContent = semestre.libelle;
                        if (selectedId && semestre.id == selectedId) {
                            option.selected = true;
                        }
                        semestreSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    toast('Erreur lors du chargement des semestres', 'error');
                });
        }
    }

    // Fonction pour charger les UE par niveau
    function loadUesByNiveau(niveauId, selectedId) {
        if (niveauId) {
            fetch(`/get-ues-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    ueSelect.innerHTML = '<option value="">Sélectionner une UE</option>';
                    data.forEach(ue => {
                        const option = document.createElement('option');
                        option.value = ue.id;
                        option.textContent = `${ue.libelle} (${ue.total_credit} crédits)`;
                        if (selectedId && ue.id == selectedId) {
                            option.selected = true;
                        }
                        ueSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    toast('Erreur lors du chargement des UE', 'error');
                });
        }
    }

    // Charger les données initiales
    const initialDepartement = departementSelect.value;
    const initialNiveau = "{{ old('niveau_id', $matiere->niveau_id) }}";
    const initialSemestre = "{{ old('semestre_id', $matiere->semestre_id) }}";
    const initialUe = "{{ old('unite_enseignement_id', $matiere->unite_enseignement_id) }}";

    if (initialDepartement) {
        loadNiveauxByDepartement(initialDepartement, initialNiveau);
    }

    if (initialNiveau) {
        loadSemestresByNiveau(initialNiveau, initialSemestre);
        loadUesByNiveau(initialNiveau, initialUe);
    }

    // Événements
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        if (departementId) {
            loadNiveauxByDepartement(departementId);
        }
    });

    niveauSelect.addEventListener('change', function() {
        const niveauId = this.value;
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        if (niveauId) {
            loadSemestresByNiveau(niveauId);
            loadUesByNiveau(niveauId);
        }
    });
});
</script>
@endpush
@endsection
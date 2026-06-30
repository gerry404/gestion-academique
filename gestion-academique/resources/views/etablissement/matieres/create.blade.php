{{-- resources/views/etablissement/matieres/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouvelle matière - EduManager')

@php
    $pageTitle = 'Nouvelle matière';
    $pageSub = 'Ajouter une matière à une UE';
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

        <form action="{{ route('matieres.store') }}" method="POST" class="space-y-4" id="matiereForm">
            @csrf

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

            <!-- Niveau (dynamique) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('niveau_id') border-red-500 @enderror"
                        required disabled>
                    <option value="">Sélectionner d'abord un département</option>
                </select>
                @error('niveau_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('semestre_id') border-red-500 @enderror"
                        required disabled>
                    <option value="">Sélectionner d'abord un niveau</option>
                </select>
                @error('semestre_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- UE (dynamique) -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Unité d'enseignement *</label>
                <select name="unite_enseignement_id" id="ue_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('unite_enseignement_id') border-red-500 @enderror"
                        required disabled>
                    <option value="">Sélectionner d'abord un niveau</option>
                </select>
                @error('unite_enseignement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-400 mt-1" id="ue_credit_info">
                    <i class="fa-solid fa-info-circle"></i> Le total des crédits des matières ne doit pas dépasser le crédit total de l'UE
                </p>
            </div>

            <!-- Enseignant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Enseignant</label>
                <select name="personnel_id"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('personnel_id') border-red-500 @enderror">
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($personnels as $personnel)
                        <option value="{{ $personnel->id }}" {{ old('personnel_id') == $personnel->id ? 'selected' : '' }}>
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
                    <input type="text" name="code" value="{{ old('code') }}"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('code') border-red-500 @enderror"
                           placeholder="Ex: INF-101" required>
                    @error('code')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Crédits *</label>
                    <input type="number" name="credit" id="credit_input" value="{{ old('credit') }}"
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
                <input type="text" name="libelle" value="{{ old('libelle') }}"
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
                           {{ old('est_actif', true) ? 'checked' : '' }}
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
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer
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
    const creditInput = document.getElementById('credit_input');
    const creditValidationMsg = document.getElementById('credit_validation_message');
    const ueCreditInfo = document.getElementById('ue_credit_info');

    let ueTotalCredit = 0;

    // ============================================
    // 1. Charger les niveaux par département
    // ============================================
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        
        // Réinitialiser tous les selects
        resetAllSelects();
        
        if (departementId) {
            niveauSelect.disabled = false;
            niveauSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-niveaux-by-departement?departement_id=${departementId}`)
                .then(response => response.json())
                .then(data => {
                    niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                    data.forEach(niveau => {
                        const option = document.createElement('option');
                        option.value = niveau.id;
                        option.textContent = niveau.display_name;
                        niveauSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    niveauSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des niveaux', 'error');
                });
        } else {
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        }
    });

    // ============================================
    // 2. Charger les semestres et UE par niveau
    // ============================================
    niveauSelect.addEventListener('change', function() {
        const niveauId = this.value;
        
        semestreSelect.disabled = true;
        ueSelect.disabled = true;
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        if (niveauId) {
            // Charger les semestres
            semestreSelect.disabled = false;
            semestreSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-semestres-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    semestreSelect.innerHTML = '<option value="">Sélectionner un semestre</option>';
                    data.forEach(semestre => {
                        const option = document.createElement('option');
                        option.value = semestre.id;
                        option.textContent = semestre.libelle;
                        semestreSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    semestreSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des semestres', 'error');
                });
            
            // Charger les UE
            ueSelect.disabled = false;
            ueSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-ues-by-niveau?niveau_id=${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    ueSelect.innerHTML = '<option value="">Sélectionner une UE</option>';
                    data.forEach(ue => {
                        const option = document.createElement('option');
                        option.value = ue.id;
                        option.textContent = `${ue.libelle} (${ue.total_credit} crédits)`;
                        ueSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    ueSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des UE', 'error');
                });
        }
    });

    // ============================================
    // 3. Mettre à jour les informations de l'UE
    // ============================================
    ueSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const text = selectedOption.textContent;
        const match = text.match(/\((\d+)\s*crédits\)/);
        
        if (match) {
            ueTotalCredit = parseInt(match[1]);
            ueCreditInfo.innerHTML = `
                <i class="fa-solid fa-info-circle"></i> 
                Total crédits UE: <strong>${ueTotalCredit}</strong> | 
                Crédit de la matière: <span id="current_credit_display">0</span>
            `;
            validateCredit();
        } else {
            ueTotalCredit = 0;
            ueCreditInfo.innerHTML = `
                <i class="fa-solid fa-info-circle"></i> 
                Le total des crédits des matières ne doit pas dépasser le crédit total de l'UE
            `;
        }
    });

    // ============================================
    // 4. Valider les crédits en temps réel
    // ============================================
    creditInput.addEventListener('input', validateCredit);

    function validateCredit() {
        const credit = parseInt(creditInput.value) || 0;
        const currentCreditDisplay = document.getElementById('current_credit_display');
        
        if (currentCreditDisplay) {
            currentCreditDisplay.textContent = credit;
        }
        
        if (ueTotalCredit > 0 && credit > ueTotalCredit) {
            creditValidationMsg.innerHTML = `
                <span class="text-red-500">
                    ⚠️ Le crédit (${credit}) dépasse le total de l'UE (${ueTotalCredit})
                </span>
            `;
            creditInput.classList.add('border-red-500');
        } else if (ueTotalCredit > 0) {
            creditValidationMsg.innerHTML = `
                <span class="text-green-600">
                    ✓ Crédit valide (max: ${ueTotalCredit})
                </span>
            `;
            creditInput.classList.remove('border-red-500');
        } else {
            creditValidationMsg.innerHTML = '';
            creditInput.classList.remove('border-red-500');
        }
    }

    // ============================================
    // 5. Réinitialiser tous les selects
    // ============================================
    function resetAllSelects() {
        niveauSelect.disabled = true;
        semestreSelect.disabled = true;
        ueSelect.disabled = true;
        
        niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord un département</option>';
        semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        ueSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        
        ueTotalCredit = 0;
        creditValidationMsg.innerHTML = '';
        creditInput.classList.remove('border-red-500');
    }

    // ============================================
    // 6. Si un département est pré-sélectionné (erreur de validation)
    // ============================================
    if (departementSelect.value) {
        departementSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
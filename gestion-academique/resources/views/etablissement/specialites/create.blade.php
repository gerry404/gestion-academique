{{-- resources/views/etablissement/niveaux/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Nouveau niveau - EduManager')

@php
    $pageTitle = 'Nouveau niveau';
    $pageSub = 'Ajouter un niveau à une spécialité';
@endphp

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
        {{-- Affichage des erreurs générales --}}
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

        <form action="{{ route('niveaux.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Année académique --}}
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

            {{-- Département --}}
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Département *</label>
                <select name="departement_id" id="departement_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('departement_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ old('departement_id', $selectedDepartement ?? '') == $departement->id ? 'selected' : '' }}>
                            {{ $departement->libelle }} ({{ $departement->code }})
                        </option>
                    @endforeach
                </select>
                @error('departement_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Spécialité --}}
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                <select name="specialite_id" id="specialite_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('specialite_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner une spécialité</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite->id }}" 
                                data-departement="{{ $specialite->departement_id }}"
                                {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                            {{ $specialite->libelle }} ({{ $specialite->code }})
                        </option>
                    @endforeach
                </select>
                @error('specialite_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">
                    <i class="fa-solid fa-info-circle"></i> La spécialité doit appartenir au département sélectionné.
                </p>
            </div>

            {{-- Libellé --}}
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle') }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: L1, L2, L3, M1, M2" required>
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-slate-400 mt-1">
                    <i class="fa-solid fa-info-circle"></i> Exemples : L1, L2, L3, M1, M2
                </p>
            </div>

            {{-- Statut actif --}}
            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           {{ old('est_actif', true) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Niveau actif</span>
                </label>
            </div>

            {{-- Boutons --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('niveaux.index') }}"
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
    const specialiteSelect = document.getElementById('specialite_select');

    /**
     * Charge les spécialités en fonction du département sélectionné
     */
    function loadSpecialites(departementId, selectedId = null) {
        if (departementId) {
            // Afficher un indicateur de chargement
            specialiteSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-specialites?departement_id=${departementId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
                    
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
                            option.textContent = `${specialite.libelle} (${specialite.code})`;
                            if (selectedId && specialite.id == selectedId) {
                                option.selected = true;
                            }
                            specialiteSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    specialiteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    toast('Erreur lors du chargement des spécialités', 'error');
                });
        } else {
            specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
        }
    }

    // Charger les spécialités initiales si un département est déjà sélectionné
    const initialDepartement = departementSelect.value;
    const initialSpecialite = "{{ old('specialite_id') }}";
    if (initialDepartement) {
        loadSpecialites(initialDepartement, initialSpecialite);
    }

    // Écouter le changement de département
    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        const oldSpecialite = specialiteSelect.value;
        loadSpecialites(departementId, oldSpecialite);
    });

    // Validation supplémentaire avant soumission
    document.querySelector('form').addEventListener('submit', function(e) {
        const departementId = departementSelect.value;
        const specialiteId = specialiteSelect.value;
        
        if (departementId && specialiteId) {
            // Vérifier que la spécialité sélectionnée appartient au département
            const selectedOption = specialiteSelect.options[specialiteSelect.selectedIndex];
            const specialiteDepartement = selectedOption?.dataset?.departement;
            
            if (specialiteDepartement && specialiteDepartement != departementId) {
                e.preventDefault();
                toast('La spécialité sélectionnée n\'appartient pas au département choisi.', 'error');
                specialiteSelect.focus();
                specialiteSelect.classList.add('border-red-500');
                setTimeout(() => {
                    specialiteSelect.classList.remove('border-red-500');
                }, 3000);
            }
        }
    });
});
</script>
@endpush
@endsection
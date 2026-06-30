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
        {{-- ✅ CORRECT : action vers store, pas update --}}
        <form action="{{ route('niveaux.store') }}" method="POST" class="space-y-4">
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

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                <select name="specialite_id" id="specialite_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('specialite_id') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionner une spécialité</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                            {{ $specialite->libelle }} ({{ $specialite->code }})
                        </option>
                    @endforeach
                </select>
                @error('specialite_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Libellé *</label>
                <input type="text" name="libelle" value="{{ old('libelle') }}"
                       class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition @error('libelle') border-red-500 @enderror"
                       placeholder="Ex: L1, L2, L3, M1, M2" required>
                @error('libelle')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center gap-3 text-sm">
                    <input type="checkbox" name="est_actif" value="1"
                           {{ old('est_actif', true) ? 'checked' : '' }}
                           class="accent-brand-600 rounded w-4 h-4">
                    <span class="text-slate-600">Niveau actif</span>
                </label>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('niveaux.index') }}"
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departementSelect = document.getElementById('departement_select');
    const specialiteSelect = document.getElementById('specialite_select');

    function loadSpecialites(departementId, selectedId = null) {
        if (departementId) {
            fetch(`/get-specialites?departement_id=${departementId}`)
                .then(response => response.json())
                .then(data => {
                    specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
                    data.forEach(specialite => {
                        const option = document.createElement('option');
                        option.value = specialite.id;
                        option.textContent = `${specialite.libelle} (${specialite.code})`;
                        if (selectedId && specialite.id == selectedId) {
                            option.selected = true;
                        }
                        specialiteSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    toast('Erreur lors du chargement des spécialités', 'error');
                });
        } else {
            specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
        }
    }

    const initialDepartement = departementSelect.value;
    const initialSpecialite = "{{ old('specialite_id') }}";
    if (initialDepartement) {
        loadSpecialites(initialDepartement, initialSpecialite);
    }

    departementSelect.addEventListener('change', function() {
        const departementId = this.value;
        loadSpecialites(departementId);
    });
});
</script>
@endpush
@endsection
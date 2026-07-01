{{-- resources/views/notes/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Saisie des notes - EduManager')

@php
    $pageTitle = 'Saisie des notes';
    $pageSub = 'Enregistrer les notes des étudiants';
@endphp

@section('content')
<div class="max-w-3xl mx-auto">
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

        <form action="{{ route('notes.store') }}" method="POST" class="space-y-4" id="noteForm">
            @csrf

            <!-- Étape 1: Année académique -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Année académique *</label>
                <select name="annee_academique_id" id="annee_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required>
                    <option value="">Sélectionner une année</option>
                    @foreach($annees as $annee)
                        <option value="{{ $annee->id }}" {{ $selectedAnnee == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Étape 2: Spécialité -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Spécialité *</label>
                <select name="specialite_id" id="specialite_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required disabled>
                    <option value="">Sélectionner d'abord une année</option>
                    @foreach($specialites as $specialite)
                        <option value="{{ $specialite->id }}" {{ $selectedSpecialite == $specialite->id ? 'selected' : '' }}>
                            {{ $specialite->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Étape 3: Niveau -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Niveau *</label>
                <select name="niveau_id" id="niveau_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required disabled>
                    <option value="">Sélectionner d'abord une spécialité</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" {{ $selectedNiveau == $niveau->id ? 'selected' : '' }}>
                            {{ $niveau->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Étape 4: Semestre -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Semestre *</label>
                <select name="semestre_id" id="semestre_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required disabled>
                    <option value="">Sélectionner d'abord un niveau</option>
                    @foreach($semestres as $semestre)
                        <option value="{{ $semestre->id }}" {{ $selectedSemestre == $semestre->id ? 'selected' : '' }}>
                            {{ $semestre->libelle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Étape 5: Matière -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Matière *</label>
                <select name="matiere_id" id="matiere_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required disabled>
                    <option value="">Sélectionner d'abord un semestre</option>
                    @foreach($matieres as $matiere)
                        <option value="{{ $matiere->id }}" {{ $selectedMatiere == $matiere->id ? 'selected' : '' }}>
                            {{ $matiere->libelle }} ({{ $matiere->credit }} crédits)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Étape 6: Étudiant -->
            <div>
                <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Étudiant *</label>
                <select name="etudiant_id" id="etudiant_select"
                        class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                        required disabled>
                    <option value="">Sélectionner d'abord une matière</option>
                    @foreach($etudiants as $etudiant)
                        <option value="{{ $etudiant->id }}">
                            {{ $etudiant->nom_complet }} ({{ $etudiant->matricule }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Champs cachés -->
            <input type="hidden" name="inscription_id" id="inscription_id">

            <!-- Notes -->
            <div class="grid sm:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Contrôle continu (30%) *</label>
                    <input type="number" name="note_cc" id="note_cc"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                           step="0.5" min="0" max="20" placeholder="0-20" required>
                </div>
                <div>
                    <label class="text-xs font-semibold text-slate-600 uppercase tracking-wider">Examen (70%) *</label>
                    <input type="number" name="note_examen" id="note_examen"
                           class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:border-brand-500 focus:ring-2 focus:ring-brand-100 outline-none transition"
                           step="0.5" min="0" max="20" placeholder="0-20" required>
                </div>
            </div>

            <!-- Résultat automatique -->
            <div class="p-4 bg-brand-50 border border-brand-200 rounded-xl text-sm text-brand-800" id="resultat">
                <i class="fa-solid fa-calculator mr-2"></i>
                Moyenne = (CC × 30%) + (Examen × 70%)
                <span class="font-bold" id="moyenne_affichage">-</span>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('notes.index') }}"
                   class="px-4 py-2.5 border border-slate-200 rounded-xl text-sm hover:bg-slate-50 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="px-5 py-2.5 grad-blue text-white rounded-xl text-sm font-semibold shadow hover:opacity-95 transition">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Enregistrer la note
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const anneeSelect = document.getElementById('annee_select');
    const specialiteSelect = document.getElementById('specialite_select');
    const niveauSelect = document.getElementById('niveau_select');
    const semestreSelect = document.getElementById('semestre_select');
    const matiereSelect = document.getElementById('matiere_select');
    const etudiantSelect = document.getElementById('etudiant_select');
    const inscriptionId = document.getElementById('inscription_id');
    const noteCc = document.getElementById('note_cc');
    const noteExamen = document.getElementById('note_examen');
    const moyenneAffichage = document.getElementById('moyenne_affichage');

    // ============================================
    // 1. Charger les spécialités par année
    // ============================================
    anneeSelect.addEventListener('change', function() {
        const anneeId = this.value;
        resetSelects(['specialite_select', 'niveau_select', 'semestre_select', 'matiere_select', 'etudiant_select']);
        
        if (anneeId) {
            specialiteSelect.disabled = false;
            specialiteSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-specialites-by-annee?annee_academique_id=${anneeId}`)
                .then(response => response.json())
                .then(data => {
                    specialiteSelect.innerHTML = '<option value="">Sélectionner une spécialité</option>';
                    data.forEach(specialite => {
                        const option = document.createElement('option');
                        option.value = specialite.id;
                        option.textContent = specialite.libelle;
                        specialiteSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    specialiteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            specialiteSelect.disabled = true;
            specialiteSelect.innerHTML = '<option value="">Sélectionner d\'abord une année</option>';
        }
    });

    // ============================================
    // 2. Charger les niveaux par spécialité
    // ============================================
    specialiteSelect.addEventListener('change', function() {
        const specialiteId = this.value;
        resetSelects(['niveau_select', 'semestre_select', 'matiere_select', 'etudiant_select']);
        
        if (specialiteId) {
            niveauSelect.disabled = false;
            niveauSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-niveaux-by-specialite?specialite_id=${specialiteId}`)
                .then(response => response.json())
                .then(data => {
                    niveauSelect.innerHTML = '<option value="">Sélectionner un niveau</option>';
                    data.forEach(niveau => {
                        const option = document.createElement('option');
                        option.value = niveau.id;
                        option.textContent = niveau.libelle;
                        niveauSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    niveauSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            niveauSelect.disabled = true;
            niveauSelect.innerHTML = '<option value="">Sélectionner d\'abord une spécialité</option>';
        }
    });

    // ============================================
    // 3. Charger les semestres par niveau
    // ============================================
    niveauSelect.addEventListener('change', function() {
        const niveauId = this.value;
        resetSelects(['semestre_select', 'matiere_select', 'etudiant_select']);
        
        if (niveauId) {
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
                });
        } else {
            semestreSelect.disabled = true;
            semestreSelect.innerHTML = '<option value="">Sélectionner d\'abord un niveau</option>';
        }
    });

    // ============================================
    // 4. Charger les matières par semestre
    // ============================================
    semestreSelect.addEventListener('change', function() {
        const semestreId = this.value;
        resetSelects(['matiere_select', 'etudiant_select']);
        
        if (semestreId) {
            matiereSelect.disabled = false;
            matiereSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-matieres-by-semestre?semestre_id=${semestreId}`)
                .then(response => response.json())
                .then(data => {
                    matiereSelect.innerHTML = '<option value="">Sélectionner une matière</option>';
                    data.forEach(matiere => {
                        const option = document.createElement('option');
                        option.value = matiere.id;
                        option.textContent = matiere.libelle + ' (' + matiere.credit + ' crédits)';
                        matiereSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            matiereSelect.disabled = true;
            matiereSelect.innerHTML = '<option value="">Sélectionner d\'abord un semestre</option>';
        }
    });

    // ============================================
    // 5. Charger les étudiants par matière
    // ============================================
    matiereSelect.addEventListener('change', function() {
        const matiereId = this.value;
        const anneeId = anneeSelect.value;
        resetSelects(['etudiant_select']);
        
        if (matiereId && anneeId) {
            etudiantSelect.disabled = false;
            etudiantSelect.innerHTML = '<option value="">Chargement...</option>';
            
            fetch(`/get-etudiants-by-matiere?matiere_id=${matiereId}&annee_academique_id=${anneeId}`)
                .then(response => response.json())
                .then(data => {
                    etudiantSelect.innerHTML = '<option value="">Sélectionner un étudiant</option>';
                    data.forEach(etudiant => {
                        const option = document.createElement('option');
                        option.value = etudiant.id;
                        option.textContent = etudiant.prenom + ' ' + etudiant.nom + ' (' + etudiant.matricule + ')';
                        etudiantSelect.appendChild(option);
                    });
                })
                .catch(() => {
                    etudiantSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                });
        } else {
            etudiantSelect.disabled = true;
            etudiantSelect.innerHTML = '<option value="">Sélectionner d\'abord une matière</option>';
        }
    });

    // ============================================
    // 6. Charger l'inscription de l'étudiant
    // ============================================
    etudiantSelect.addEventListener('change', function() {
        const etudiantId = this.value;
        const anneeId = anneeSelect.value;
        
        if (etudiantId && anneeId) {
            fetch(`/get-inscription?etudiant_id=${etudiantId}&annee_academique_id=${anneeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.id) {
                        inscriptionId.value = data.id;
                    } else {
                        inscriptionId.value = '';
                        toast('Aucune inscription validée trouvée pour cet étudiant', 'warning');
                    }
                })
                .catch(() => {
                    inscriptionId.value = '';
                });
        }
    });

    // ============================================
    // 7. Calculer la moyenne en temps réel
    // ============================================
    function calculateMoyenne() {
        const cc = parseFloat(noteCc.value) || 0;
        const examen = parseFloat(noteExamen.value) || 0;
        
        if (cc >= 0 && cc <= 20 && examen >= 0 && examen <= 20) {
            const moyenne = (cc * 0.3) + (examen * 0.7);
            moyenneAffichage.textContent = moyenne.toFixed(2) + '/20';
            moyenneAffichage.style.color = moyenne >= 10 ? '#16a34a' : '#dc2626';
        } else {
            moyenneAffichage.textContent = '-';
        }
    }

    noteCc.addEventListener('input', calculateMoyenne);
    noteExamen.addEventListener('input', calculateMoyenne);

    // ============================================
    // 8. Utilitaires
    // ============================================
    function resetSelects(selectIds) {
        selectIds.forEach(id => {
            const select = document.getElementById(id);
            if (select) {
                select.disabled = true;
                select.innerHTML = '<option value="">Sélectionner d\'abord</option>';
            }
        });
    }

    // ============================================
    // 9. Si des valeurs sont pré-sélectionnées
    // ============================================
    if (anneeSelect.value) {
        anneeSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection
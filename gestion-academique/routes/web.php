<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Etablissement\AnneeAcademiqueController;
use App\Http\Controllers\Etablissement\DepartementController;
use App\Http\Controllers\Etablissement\SpecialiteController;
use App\Http\Controllers\Etablissement\NiveauController;
use App\Http\Controllers\Etablissement\SemestreController;
use App\Http\Controllers\Etablissement\PersonnelController;
use App\Http\Controllers\Etablissement\UEController;
use App\Http\Controllers\Notes\NoteController;
use App\Http\Controllers\Etablissement\MatiereController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\EffetsAcademiques\CarteEtudiantController;



// ============================================
// ROUTES PUBLIQUES
// ============================================

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// ROUTES PROTÉGÉES (AUTHENTIFICATION REQUISE)
// ============================================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ============================================
    // ROUTES ADMIN UNIQUEMENT
    // ============================================

    Route::middleware(['role:admin'])->group(function () {

        // ----- Années académiques -----
        Route::resource('annees-academiques', AnneeAcademiqueController::class)
            ->parameters(['annees-academiques' => 'anneeAcademique']);
        Route::patch('annees-academiques/{anneeAcademique}/toggle-status', [AnneeAcademiqueController::class, 'toggleStatus'])->name('annees-academiques.toggle-status');

        // ----- Départements -----
        Route::resource('departements', DepartementController::class);
        Route::patch('departements/{departement}/toggle-status', [DepartementController::class, 'toggleStatus'])->name('departements.toggle-status');
        Route::patch('departements/{departement}/nommer-chef', [DepartementController::class, 'nommerChef'])->name('departements.nommer-chef');
        Route::patch('departements/{departement}/retirer-chef', [DepartementController::class, 'retirerChef'])->name('departements.retirer-chef');

        // ----- Spécialités -----
        Route::resource('specialites', SpecialiteController::class);
        Route::patch('specialites/{specialite}/toggle-status', [SpecialiteController::class, 'toggleStatus'])->name('specialites.toggle-status');

        // ----- Niveaux -----
        Route::resource('niveaux', NiveauController::class);
        Route::patch('niveaux/{niveau}/toggle-status', [NiveauController::class, 'toggleStatus'])->name('niveaux.toggle-status');
        Route::get('get-specialites', [NiveauController::class, 'getSpecialites'])->name('get-specialites');

        // ----- Semestres -----
        Route::resource('semestres', SemestreController::class);
        Route::patch('semestres/{semestre}/toggle-status', [SemestreController::class, 'toggleStatus'])->name('semestres.toggle-status');

        // ----- Diplômes -----
        //Route::resource('diplomes', DiplomeController::class);
        //Route::patch('diplomes/{diplome}/toggle-status', [DiplomeController::class, 'toggleStatus'])->name('diplomes.toggle-status');

        // ----- Personnel -----
        Route::resource('personnels', PersonnelController::class);
        Route::patch('personnels/{personnel}/toggle-status', [PersonnelController::class, 'toggleStatus'])->name('personnels.toggle-status');
        Route::get('personnels/{personnel}/create-user', [PersonnelController::class, 'createUser'])->name('personnels.create-user');
        Route::post('personnels/{personnel}/store-user', [PersonnelController::class, 'storeUser'])->name('personnels.store-user');
        Route::delete('personnels/{personnel}/detach-user', [PersonnelController::class, 'detachUser'])->name('personnels.detach-user');

        // ----- Unités d'enseignement -----
        Route::resource('ues', UEController::class);

        // ----- Matières (UN SEUL) -----
        Route::resource('matieres', MatiereController::class);
        Route::patch('matieres/{matiere}/toggle-status', [MatiereController::class, 'toggleStatus'])->name('matieres.toggle-status');

        // ✅ Routes AJAX pour les filtres en cascade
        Route::get('get-niveaux-by-departement', [MatiereController::class, 'getNiveauxByDepartement'])->name('get.niveaux.by.departement');
        Route::get('get-semestres-by-niveau', [MatiereController::class, 'getSemestresByNiveau'])->name('get.semestres.by.niveau');
        Route::get('get-ues-by-niveau', [MatiereController::class, 'getUesByNiveau'])->name('get.ues.by.niveau');

        // ----- Administration -----
        Route::get('/users', function () {
            return view('administration.users');
        })->name('users.index');

        Route::get('/settings', function () {
            return view('administration.settings');
        })->name('settings.index');
    });
     // Route::resource('diplomes', DiplomeController::class);
     // Route::patch('diplomes/{diplome}/toggle-status', [DiplomeController::class, 'toggleStatus'])->name('diplomes.toggle-status');  
    // ============================================
    // ROUTES ÉTUDIANTS
    // ============================================
    Route::resource('etudiants', EtudiantController::class);
    Route::patch('etudiants/{etudiant}/toggle-status', [EtudiantController::class, 'toggleStatus'])->name('etudiants.toggle-status');

    // ============================================
    // ROUTES INSCRIPTIONS
    // ============================================
    Route::resource('inscriptions', InscriptionController::class);
    Route::patch('inscriptions/{inscription}/valider', [InscriptionController::class, 'valider'])->name('inscriptions.valider');
    Route::patch('inscriptions/{inscription}/annuler', [InscriptionController::class, 'annuler'])->name('inscriptions.annuler');
    Route::get('get-specialites-by-departement', [InscriptionController::class, 'getSpecialitesByDepartement'])
    ->name('get.specialites.by.departement');
    Route::get('get-niveaux-by-specialite', [InscriptionController::class, 'getNiveauxBySpecialite'])
    ->name('get.niveaux.by.specialite');



    // Notes - Routes AJAX pour la cascade
    Route::get('get-specialites-by-annee', [NoteController::class, 'getSpecialitesByAnnee'])->name('get.specialites.by.annee');
    Route::get('get-niveaux-by-specialite', [NoteController::class, 'getNiveauxBySpecialite'])->name('get.niveaux.by.specialite');
    Route::get('get-semestres-by-niveau', [NoteController::class, 'getSemestresByNiveau'])->name('get.semestres.by.niveau');
    Route::get('get-matieres-by-semestre', [NoteController::class, 'getMatieresBySemestre'])->name('get.matieres.by.semestre');
    Route::get('get-etudiants-by-matiere', [NoteController::class, 'getEtudiantsByMatiere'])->name('get.etudiants.by.matiere');
    Route::get('get-inscription', [NoteController::class, 'getInscription'])->name('get.inscription');

    // Notes CRUD
    Route::resource('notes', NoteController::class);
    // Effets académiques - Cartes
    Route::get('/cartes-etudiant', [CarteEtudiantController::class, 'index'])->name('cartes.index');
    Route::get('/cartes-etudiant/{id}', [CarteEtudiantController::class, 'show'])->name('cartes.show');
    Route::get('/cartes-etudiant/{id}/download', [CarteEtudiantController::class, 'download'])->name('cartes.download');


    
    // ============================================
    // ROUTES EMPLOYÉ
    // ============================================

   /* Route::middleware(['role:employe'])->group(function () {
        Route::get('/etudiants', function () {
            return view('etudiants.index');
        })->name('etudiants.index');

        Route::get('/inscriptions', function () {
            return view('inscriptions.index');
        })->name('inscriptions.index');

        Route::get('/notes', function () {
            return view('notes.index');
        })->name('notes.index');

        Route::get('/releves', function () {
            return view('effets.releves');
        })->name('releves.index');

        Route::get('/cartes', function () {
            return view('effets.cartes');
        })->name('cartes.index');

        Route::get('/statistiques', function () {
            return view('statistiques.index');
        })->name('statistiques.index');

        Route::post('/etudiants', function () {
            return redirect()->back()->with('success', 'Étudiant créé avec succès.');
        })->name('etudiants.store');

        Route::post('/inscriptions', function () {
            return redirect()->back()->with('success', 'Inscription enregistrée avec succès.');
        })->name('inscriptions.store');

        Route::post('/notes', function () {
            return redirect()->back()->with('success', 'Notes saisies avec succès.');
        })->name('notes.store');
    });*/
});
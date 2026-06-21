<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes API
|--------------------------------------------------------------------------
| Toutes ces routes sont prefixees automatiquement par /api
| Voir bootstrap/app.php pour la configuration.
*/

// --- Routes publiques (pas besoin d'etre connecte) ---
Route::post('/login', [AuthController::class, 'login']);

// --- Routes protegees (necessite d'etre connecte) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- Modules metier (a implementer par l'equipe) ---
    // Route::apiResource('annees-academiques', AnneeAcademiqueController::class);
    // Route::apiResource('departements', DepartementController::class);
    // Route ::apiResource('specialites', SpecialiteController::class);
    // Route::apiResource('niveaux', NiveauController::class);
    // Route::apiResource('ue', UEController::class);
    // Route::apiResource('matieres', MatiereController::class);
    // Route::apiResource('diplomes', DiplomeController::class);
    // Route::apiResource('personnels', PersonnelController::class);
    // Route::apiResource('etudiants', EtudiantController::class);
    // Route::apiResource('inscriptions', InscriptionController::class);
    // Route::apiResource('notes', NoteController::class);
});

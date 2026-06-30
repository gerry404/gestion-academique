<?php

/*use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Etablissement\AnneeAcademiqueController;
use App\Http\Controllers\Api\Etablissement\PersonnelController;
use App\Http\Controllers\Api\Etablissement\UniteEnseignementController;
use App\Http\Controllers\Api\Etablissement\DepartementController;
use App\Http\Controllers\Api\Etablissement\MatiereController;
use App\Http\Controllers\Api\Etablissement\SemestreController;
use App\Http\Controllers\Api\Etablissement\NiveauController;
use App\Http\Controllers\Api\Etablissement\SpecialiteController;
use App\Http\Controllers\Api\Etablissement\EnseignantController;



/*
|--------------------------------------------------------------------------
| Routes API
|--------------------------------------------------------------------------
| Toutes ces routes sont prefixees automatiquement par /api
| Voir bootstrap/app.php pour la configuration.


// --- Routes publiques (pas besoin d'etre connecte) ---
Route::post('/login', [AuthController::class, 'login']);

// --- Routes protegees (necessite d'etre connecte) ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- Modules metier (Lecture seule pour Employé et Admin) ---
    Route::apiResource('annees-academiques', AnneeAcademiqueController::class)
       ->only(['index', 'show'])
       ->parameters(['annees-academiques' => 'anneeAcademique']); 
    Route::get('annees-academiques/{anneeAcademique}/stats', [AnneeAcademiqueController::class, 'stats']);
    Route::apiResource('departements', DepartementController::class)->only(['index', 'show']);
    Route::apiResource('specialites', SpecialiteController::class)->only(['index', 'show']);
    Route::apiResource('niveaux', NiveauController::class)->only(['index', 'show']);
    Route::apiResource('enseignants', EnseignantController::class)->only(['index', 'show']);
    Route::apiResource('semestres', SemestreController::class)->only(['index', 'show']);
    Route::apiResource('matieres', MatiereController::class)->only(['index', 'show']);
    Route::apiResource('personnels', PersonnelController::class)->only(['index', 'show']);
    Route::apiResource('unites-enseignement', UniteEnseignementController::class)->only(['index', 'show']);
    Route::get('unites-enseignement/par-niveau/{niveau_id}', [UniteEnseignementController::class, 'parNiveau']);

    // --- Routes protégées par rôle Admin (Écriture) ---
    Route::middleware('role:admin')->group(function () {

        Route::apiResource('annees-academiques', AnneeAcademiqueController::class)->except(['index', 'show'])
                 ->parameters(['annees-academiques' => 'anneeAcademique']); 
        Route::patch('annees-academiques/{anneeAcademique}/toggle-status', [AnneeAcademiqueController::class, 'toggleStatus']);

       // Départements

        Route::get('/list', [DepartementController::class, 'list']);
        Route::get('/chefs-disponibles', [DepartementController::class, 'chefsDisponibles']);
        Route::get('{departement}/stats', [DepartementController::class, 'stats']);
        Route::patch('departements/{departement}/toggle-status', [DepartementController::class, 'toggleStatus']);
        Route::patch('departements/{departement}/nommer-chef', [DepartementController::class, 'nommerChef']);
        Route::patch('departements/{departement}/retirer-chef', [DepartementController::class, 'retirerChef']);
        Route::get('departements/export', [DepartementController::class, 'export']);
        Route::apiResource('departements', DepartementController::class);
      

        Route::apiResource('specialites', SpecialiteController::class)->except(['index', 'show']);
        Route::apiResource('niveaux', NiveauController::class)->except(['index', 'show']);
        Route::apiResource('enseignants', EnseignantController::class)->except(['index', 'show']);
        Route::apiResource('semestres', SemestreController::class)->except(['index', 'show']);
        Route::apiResource('matieres', MatiereController::class)->except(['index', 'show']);

        Route::apiResource('personnels', PersonnelController::class)->except(['index', 'show']);
        Route::patch('personnels/{personnel}/lier-user', [PersonnelController::class, 'lierUser']);
        Route::patch('personnels/{personnel}/delier-user', [PersonnelController::class, 'delierUser']);

        Route::apiResource('unites-enseignement', UniteEnseignementController::class)->except(['index', 'show']);
        Route::post('unites-enseignement/reordonner', [UniteEnseignementController::class, 'reordonner']);
    });
});

*/



   


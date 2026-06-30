<?php
// database/seeders/RolesAndPermissionsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Réinitialiser le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // CRÉATION DES PERMISSIONS
        // ============================================

        // Module Etablissement
        $permissions = [
            // Années académiques
            'voir_annees_academiques',
            'creer_annee_academique',
            'modifier_annee_academique',
            'supprimer_annee_academique',
            'activer_annee_academique',

            // Départements
            'voir_departements',
            'creer_departement',
            'modifier_departement',
            'supprimer_departement',
            'activer_departement',

            // Spécialités
            'voir_specialites',
            'creer_specialite',
            'modifier_specialite',
            'supprimer_specialite',
            'activer_specialite',

            // Niveaux
            'voir_niveaux',
            'creer_niveau',
            'modifier_niveau',
            'supprimer_niveau',
            'activer_niveau',

            // Semestres
            'voir_semestres',
            'creer_semestre',
            'modifier_semestre',
            'supprimer_semestre',
            'activer_semestre',

            // Unités d'enseignement
            'voir_ues',
            'creer_ue',
            'modifier_ue',
            'supprimer_ue',
            'activer_ue',

            // Matières
            'voir_matieres',
            'creer_matiere',
            'modifier_matiere',
            'supprimer_matiere',
            'activer_matiere',

            // Diplômes
            'voir_diplomes',
            'creer_diplome',
            'modifier_diplome',
            'supprimer_diplome',
            'activer_diplome',

            // Personnel
            'voir_personnels',
            'creer_personnel',
            'modifier_personnel',
            'supprimer_personnel',
            'activer_personnel',
            'creer_compte_personnel',

            // Étudiants
            'voir_etudiants',
            'creer_etudiant',
            'modifier_etudiant',
            'supprimer_etudiant',
            'activer_etudiant',
            'exporter_etudiants',

            // Inscriptions
            'voir_inscriptions',
            'creer_inscription',
            'modifier_inscription',
            'supprimer_inscription',
            'valider_inscription',

            // Notes
            'voir_notes',
            'saisir_notes',
            'modifier_notes',
            'valider_notes',
            'transférer_notes',

            // Effets académiques
            'generer_carte_etudiant',
            'generer_certificat',
            'generer_releve',
            'generer_attestation',
            'exporter_listes',

            // Statistiques
            'voir_statistiques',
            'exporter_statistiques',

            // Administration
            'gerer_utilisateurs',
            'gerer_roles',
            'gerer_permissions',
            'voir_logs',
            'gerer_parametres',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ============================================
        // CRÉATION DES RÔLES
        // ============================================

        // Rôle Admin (toutes les permissions)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // Rôle Employé (permissions limitées)
        $employeRole = Role::firstOrCreate(['name' => 'employe', 'guard_name' => 'web']);
        $employePermissions = [
            // Lecture seule pour l'établissement
            'voir_annees_academiques',
            'voir_departements',
            'voir_specialites',
            'voir_niveaux',
            'voir_semestres',
            'voir_ues',
            'voir_matieres',
            'voir_diplomes',
            'voir_personnels',
            'voir_etudiants',
            'voir_inscriptions',
            'voir_notes',
            'voir_statistiques',

            // Actions employé
            'creer_etudiant',
            'modifier_etudiant',
            'creer_inscription',
            'modifier_inscription',
            'valider_inscription',
            'saisir_notes',
            'modifier_notes',
            'generer_carte_etudiant',
            'generer_certificat',
            'generer_releve',
            'exporter_listes',
            'exporter_etudiants',
        ];

        $employeRole->syncPermissions($employePermissions);

        // Rôle Enseignant (si jamais tu l'utilises)
        $enseignantRole = Role::firstOrCreate(['name' => 'enseignant', 'guard_name' => 'web']);
        $enseignantPermissions = [
            'voir_matieres',
            'voir_etudiants',
            'saisir_notes',
            'modifier_notes',
            'voir_statistiques',
        ];
        $enseignantRole->syncPermissions($enseignantPermissions);

        $this->command->info('✅ Rôles et permissions créés avec succès !');
        $this->command->info('   - Admin : toutes les permissions');
        $this->command->info('   - Employé : permissions limitées');
        $this->command->info('   - Enseignant : permissions restreintes');
    }
}
<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $libelle
 * @property \Illuminate\Support\Carbon|null $date_debut
 * @property \Illuminate\Support\Carbon|null $date_fin
 * @property numeric $note_validation
 * @property bool $est_active
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Niveau> $niveaux
 * @property-read int|null $niveaux_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Semestre> $semestres
 * @property-read int|null $semestres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereDateDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereDateFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereEstActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereNoteValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnneeAcademique whereUpdatedAt($value)
 */
	class AnneeAcademique extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property string|null $description
 * @property bool $est_actif
 * @property int|null $chef_departement_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\Personnel|null $chefDepartement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Niveau> $niveaux
 * @property-read int|null $niveaux_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Specialite> $specialites
 * @property-read int|null $specialites_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereChefDepartementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereEstActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereUpdatedAt($value)
 */
	class Departement extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property \Illuminate\Support\Carbon|null $date_naissance
 * @property string|null $lieu_naissance
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $photo
 * @property string|null $diplome
 * @property string|null $specialite
 * @property \Illuminate\Support\Carbon|null $date_embauche
 * @property bool $est_actif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $nom_complet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant actifs()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereDateEmbauche($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereDiplome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereEstActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereSpecialite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Enseignant whereUpdatedAt($value)
 */
	class Enseignant extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property int $credit
 * @property int $departement_id
 * @property int $unite_enseignement_id
 * @property int $semestre_id
 * @property int|null $enseignant_id
 * @property int $niveau_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\Departement $departement
 * @property-read \App\Models\Etablissement\Enseignant|null $enseignant
 * @property-read \App\Models\Etablissement\Niveau $niveau
 * @property-read \App\Models\Etablissement\Semestre $semestre
 * @property-read \App\Models\Etablissement\UniteEnseignement $uniteEnseignement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereDepartementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereEnseignantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereNiveauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereSemestreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereUniteEnseignementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Matiere whereUpdatedAt($value)
 */
	class Matiere extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $libelle
 * @property int $departement_id
 * @property int $specialite_id
 * @property int $annee_academique_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\AnneeAcademique $anneeAcademique
 * @property-read \App\Models\Etablissement\Departement $departement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \App\Models\Etablissement\Specialite $specialite
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\UniteEnseignement> $unitesEnseignement
 * @property-read int|null $unites_enseignement_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereAnneeAcademiqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereDepartementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereSpecialiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Niveau whereUpdatedAt($value)
 */
	class Niveau extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $matricule
 * @property string $nom
 * @property string $prenom
 * @property string $sexe
 * @property \Illuminate\Support\Carbon|null $date_naissance
 * @property string|null $lieu_naissance
 * @property string|null $telephone
 * @property string|null $email
 * @property string|null $adresse
 * @property string|null $photo
 * @property string|null $diplome
 * @property string|null $fonction
 * @property \Illuminate\Support\Carbon|null $date_embauche
 * @property bool $est_actif
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\Departement|null $departementDirige
 * @property-read string $nom_complet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \App\Models\Etablissement\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel actifs()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel avecCompte()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel sansCompte()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereAdresse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereDateEmbauche($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereDateNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereDiplome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereEstActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereFonction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereLieuNaissance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereMatricule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereTelephone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personnel whereUserId($value)
 */
	class Personnel extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $libelle
 * @property int $annee_academique_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\AnneeAcademique $anneeAcademique
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereAnneeAcademiqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereUpdatedAt($value)
 */
	class Semestre extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property int $departement_id
 * @property bool $est_actif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\Departement $departement
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Niveau> $niveaux
 * @property-read int|null $niveaux_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereDepartementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereEstActif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialite whereUpdatedAt($value)
 */
	class Specialite extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $code
 * @property string $libelle
 * @property int $total_credit
 * @property int $position_releve
 * @property int $annee_academique_id
 * @property int $niveau_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Etablissement\AnneeAcademique $anneeAcademique
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Etablissement\Matiere> $matieres
 * @property-read int|null $matieres_count
 * @property-read \App\Models\Etablissement\Niveau $niveau
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereAnneeAcademiqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereNiveauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement wherePositionReleve($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereTotalCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UniteEnseignement whereUpdatedAt($value)
 */
	class UniteEnseignement extends \Eloquent {}
}

namespace App\Models\Etablissement{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Etablissement\Personnel|null $personnel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent {}
}


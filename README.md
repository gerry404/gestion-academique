# Gestion Scolaire

Application web de gestion d'un établissement scolaire (étudiants, notes, départements, spécialités, niveaux, matières, statistiques, etc.).

> Projet de classe — stack **Laravel 12 (PHP)** + **Flutter (Dart)** + **MySQL**.

---

## Sommaire

1. [Architecture du projet](#1-architecture-du-projet)
2. [Prérequis](#2-prérequis)
3. [Installation pas à pas (première fois)](#3-installation-pas-à-pas-première-fois)
4. [Lancer l'application](#4-lancer-lapplication)
5. [Compte de test par défaut](#5-compte-de-test-par-défaut)
6. [Modules de l'application](#6-modules-de-lapplication)
7. [Travailler en équipe avec Git/GitHub](#7-travailler-en-équipe-avec-gitgithub)
8. [Convention de commits](#8-convention-de-commits)
9. [FAQ / Problèmes fréquents](#9-faq--problèmes-fréquents)

---

## 1. Architecture du projet

```
gestion scolaire/
├── README.md                ← Ce fichier (à lire en premier)
├── .gitignore
│
├── backend/                 ← API Laravel (PHP) — port 8000
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   └── Api/
│   │   │   │       ├── AuthController.php          ← Login / Logout / Me (FAIT)
│   │   │   │       ├── Etablissement/              ← à compléter
│   │   │   │       ├── Etudiants/                  ← à compléter
│   │   │   │       ├── Notes/                      ← à compléter
│   │   │   │       ├── Effets/                     ← à compléter
│   │   │   │       ├── Statistiques/               ← à compléter
│   │   │   │       └── Administration/             ← à compléter
│   │   │   └── Requests/
│   │   │       └── Auth/LoginRequest.php
│   │   ├── Models/
│   │   │   ├── User.php                            ← compte utilisateur (FAIT)
│   │   │   ├── Etablissement/                      ← à compléter
│   │   │   ├── Etudiants/                          ← à compléter
│   │   │   └── Notes/                              ← à compléter
│   │   ├── Policies/
│   │   └── Services/Pdf/                           ← Génération PDF (cartes, certificats, relevés)
│   ├── config/
│   │   └── cors.php                                ← Autorise le frontend à appeler l'API
│   ├── database/
│   │   ├── migrations/                             ← schémas SQL
│   │   └── seeders/
│   │       └── DatabaseSeeder.php                  ← Comptes par défaut (FAIT)
│   ├── routes/
│   │   └── api.php                                 ← Routes /api/login, /api/logout, /api/me
│   └── .env.example
│
└── mobile/                 ← Application Flutter (Dart)
    └── lib/
        ├── config/app_config.dart                 ← URL de l'API (FAIT)
        ├── api/api_client.dart                     ← Client Dio + token Bearer (FAIT)
        ├── components/
        │   ├── layout/dashboard_layout.dart        ← Sidebar + topbar (FAIT)
        │   └── ui/                                 ← widgets réutilisables (à compléter)
        ├── models/                                 ← user.dart, login_credentials.dart (FAIT)
        ├── providers/auth_provider.dart            ← État global d'authentification (FAIT)
        ├── services/
        │   ├── auth_service.dart                   ← Appels API d'auth (FAIT)
        │   └── token_storage.dart                  ← Stockage sécurisé du token (FAIT)
        ├── pages/
        │   ├── login_page.dart                     ← Page de connexion (FAIT)
        │   ├── dashboard_page.dart                 ← Tableau de bord (FAIT)
        │   ├── etablissement/                      ← à compléter
        │   ├── etudiants/                          ← à compléter
        │   ├── notes/                              ← à compléter
        │   ├── effets/                             ← à compléter
        │   ├── statistiques/                       ← à compléter
        │   └── administration/                     ← à compléter
        ├── routes/app_router.dart                  ← Routes + garde d'accès (FAIT)
        └── main.dart                               ← Point d'entrée (FAIT)
```

**Ce qui est déjà fait** : architecture, **connexion / déconnexion** complète (front + back), structure des modules, comptes de test.

**Ce qu'il reste à faire** : tous les modules métier (a, b, c, d, e, f) — c'est le travail de l'équipe.

---

## 2. Prérequis

Avant de cloner le projet, installe ces outils sur ton ordinateur :

| Outil          | Version min. | Comment installer                                                |
| -------------- | ------------ | ---------------------------------------------------------------- |
| **PHP**        | 8.2+         | Via [Laragon](https://laragon.org/) (Windows) ou [XAMPP](https://www.apachefriends.org/) |
| **Composer**   | 2.x          | [getcomposer.org](https://getcomposer.org/download/)             |
| **Flutter**    | 3.x          | [docs.flutter.dev](https://docs.flutter.dev/get-started/install) |
| **MySQL**      | 8.x          | Inclus dans Laragon/XAMPP                                        |
| **Git**        | n'importe    | [git-scm.com](https://git-scm.com/)                              |

> 💡 Sur Windows, **Laragon** est très recommandé : il installe PHP + MySQL + Apache d'un coup.

Vérifie que tout est OK :

```bash
php -v            # doit afficher 8.2+
composer -V       # doit afficher 2.x
flutter --version # doit afficher 3.x
git --version
```

---

## 3. Installation pas à pas (première fois)

### Étape 1 — Cloner le repo

```bash
git clone https://github.com/<TON_USER>/<NOM_DU_REPO>.git
cd "<NOM_DU_REPO>"
```

### Étape 2 — Préparer le backend (Laravel)

```bash
cd backend

# 1. Installer les dépendances PHP
composer install

# 2. Copier le fichier d'environnement
cp .env.example .env       # Windows PowerShell : Copy-Item .env.example .env

# 3. Générer la clé d'application
php artisan key:generate
```

### Étape 3 — Créer la base de données MySQL

Ouvre **phpMyAdmin** (ou un autre client MySQL) et crée une base **vide** :

```sql
CREATE DATABASE gestion_scolaire CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Vérifie dans `backend/.env` que ces lignes correspondent à ta config locale :

```env
DB_DATABASE=gestion_scolaire
DB_USERNAME=root
DB_PASSWORD=
```

### Étape 4 — Exécuter les migrations + seeders

Toujours dans le dossier `backend/` :

```bash
php artisan migrate --seed
```

Cela crée toutes les tables **et** insère les comptes de test (voir [section 5](#5-compte-de-test-par-défaut)).

### Étape 5 — Préparer l'app mobile (Flutter)

Reviens à la racine puis :

```bash
cd ../mobile

# Installer les dépendances Dart
flutter pub get
```

---

## 4. Lancer l'application

Tu dois lancer **deux serveurs en parallèle** dans **deux terminaux différents**.

### Terminal 1 — Backend Laravel

```bash
cd backend
php artisan serve
```

➡️ API disponible sur **http://localhost:8000**

### Terminal 2 — Application Flutter

L'URL de l'API se règle via `--dart-define=API_URL=...` selon la cible :

```bash
cd mobile

# Émulateur Android (10.0.2.2 = localhost de la machine hôte) — valeur par défaut
flutter run

# Web ou Desktop (pointe vers localhost)
flutter run -d chrome  --dart-define=API_URL=http://localhost:8000
flutter run -d windows --dart-define=API_URL=http://localhost:8000

# Téléphone physique (remplace par l'IP locale de ta machine)
flutter run --dart-define=API_URL=http://192.168.x.x:8000
```

Tu verras la page de connexion.

---

## 5. Compte de test par défaut

Trois comptes sont créés automatiquement par le seeder :

| Rôle         | Email                                | Mot de passe |
| ------------ | ------------------------------------ | ------------ |
| Admin        | `admin@gestion-scolaire.local`       | `password`   |
| Responsable  | `responsable@gestion-scolaire.local` | `password`   |
| Enseignant   | `enseignant@gestion-scolaire.local`  | `password`   |

> ⚠️ Ces comptes sont uniquement pour le développement. **À supprimer ou changer en production.**

Pour les recréer (si tu casses la base) :

```bash
cd backend
php artisan migrate:fresh --seed
```

---

## 6. Modules de l'application

D'après le compte-rendu avec le professeur :

### a. Gestion de l'établissement
- Année académique (avec note minimale de validation)
- Personnel
- Département
- Spécialité (libellé + département)
- Niveau (L1, L2, L3 — par département/spécialité/session)
- UE (code, libellé, session, position sur le relevé)
- Matière (par UE/niveau/spécialité/semestre/session/professeur/crédit)
- Diplôme

### b. Gestion des étudiants
- Liste (recherche par nom et année académique)
- Inscription
- Infos étudiant
- Ajout

### c. Gestion des notes
- Liste des départements → filières → matières → attribution (CC + SN par session/crédit/semestre)
- Téléchargement de la liste des étudiants par matière

### d. Effets académiques
- Liste filières → liste étudiants / boursiers
- Génération PDF : carte étudiant, certificat, relevé de notes

### e. Statistiques générales
- À définir (taux de réussite, effectifs, moyennes, etc.)

### f. Administration
- Attribution de droits aux employés

---

## 7. Travailler en équipe avec Git/GitHub

### 🔵 Étape 1 : Cloner le repo (une seule fois)

```bash
git clone https://github.com/<USER>/<REPO>.git
cd <REPO>
```

### 🔵 Étape 2 : Créer ta propre branche AVANT de coder

**Ne travaille JAMAIS directement sur la branche `main`.** Crée une branche par fonctionnalité :

```bash
# 1. Met à jour ta version de main
git checkout main
git pull origin main

# 2. Crée ta branche (nom = ce que tu fais)
git checkout -b feature/login-etudiant
```

**Convention de nommage des branches** :
- `feature/<nom>` → nouvelle fonctionnalité (ex: `feature/ajout-etudiant`)
- `fix/<nom>` → correction de bug (ex: `fix/bug-login`)
- `docs/<nom>` → documentation (ex: `docs/readme`)

### 🔵 Étape 3 : Code, puis enregistre (commit)

```bash
# Voir ce que tu as modifié
git status

# Ajouter tes fichiers
git add .

# Faire un commit avec un message clair
git commit -m "feat: ajout du formulaire d'inscription étudiant"
```

### 🔵 Étape 4 : Envoyer ta branche sur GitHub (push)

```bash
git push origin feature/login-etudiant
```

### 🔵 Étape 5 : Créer une Pull Request (PR)

1. Va sur GitHub → ton repo
2. Clique sur **"Compare & pull request"**
3. Décris ce que tu as fait
4. Demande une review à un camarade
5. Une fois approuvée → **Merge**

### 🔵 Étape 6 : Récupérer le travail des autres

Régulièrement, met à jour ta branche locale :

```bash
git checkout main
git pull origin main

# Pour remettre les nouveautés dans ta branche en cours :
git checkout feature/ma-branche
git merge main
```

### 📋 Récapitulatif visuel

```
main ────●────●────●────●────●─────────●──── (branche principale, intouchable)
          \         \         \         /
           \         \         \       / merge (Pull Request)
            ●─────●   ●────●    ●──●──●
        feature/A    feature/B   feature/C
        (camarade 1) (camarade 2) (toi)
```

---

## 8. Convention de commits

Utilise un préfixe en début de message :

| Préfixe    | Quand l'utiliser                              |
| ---------- | --------------------------------------------- |
| `feat:`    | Nouvelle fonctionnalité                       |
| `fix:`     | Correction de bug                             |
| `docs:`    | Documentation (README, commentaires)          |
| `style:`   | Mise en forme (indentation, espaces…)         |
| `refactor:`| Réorganisation du code sans nouveau comportement |
| `test:`    | Ajout/modification de tests                   |
| `chore:`   | Tâches diverses (config, dépendances…)        |

Exemples :
- `feat: ajout de la page liste des étudiants`
- `fix: correction du calcul de moyenne par UE`
- `docs: mise à jour du README`

---

## 9. FAQ / Problèmes fréquents

### ❓ `php artisan serve` ne marche pas
Vérifie que tu as bien exécuté `composer install` et copié `.env.example` en `.env`, puis `php artisan key:generate`.

### ❓ `flutter run` plante
Lance `flutter doctor` pour vérifier ton installation, puis `flutter clean` suivi de `flutter pub get` dans le dossier `mobile/`.

### ❓ L'app n'arrive pas à joindre l'API
L'URL de l'API dépend de la cible (voir [section 4](#4-lancer-lapplication)) :
- **Émulateur Android** : `http://10.0.2.2:8000` (et non `localhost`)
- **Web / Desktop** : `http://localhost:8000`
- **Téléphone physique** : l'IP locale de ta machine (`http://192.168.x.x:8000`), téléphone et PC sur le même réseau Wi-Fi.

Passe-la avec `--dart-define=API_URL=...`. Vérifie aussi que `php artisan serve` tourne.

### ❓ Erreur 401 au login / après quelques temps
L'authentification se fait par **token Sanctum** : le token est renvoyé par `/api/login` et stocké côté app. Une 401 signifie un token absent/invalide → reconnecte-toi.

### ❓ Erreur "SQLSTATE[HY000] [1045]" (connexion MySQL refusée)
Mauvais identifiants dans `backend/.env`. Vérifie `DB_USERNAME` et `DB_PASSWORD` selon ton installation MySQL.

### ❓ J'ai un conflit Git, je fais quoi ?
1. Ouvre le fichier qui pose problème
2. Tu verras des marqueurs `<<<<<<<`, `=======`, `>>>>>>>`
3. Garde ce que tu veux, supprime les marqueurs
4. `git add <fichier>` puis `git commit`

Si tu paniques : **demande de l'aide avant de faire `git reset --hard`** (ça supprime ton travail).

---

## Crédits

Projet pédagogique — Licence libre. Bonne route à toute l'équipe ! 🚀

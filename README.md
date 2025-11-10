🚗 Touche pas au klaxon - Application de Covoiturage
📌 Description

Touche pas au klaxon est une application web de covoiturage en PHP 8, utilisant MySQL et Bootstrap 5 pour l’interface.
Elle permet aux utilisateurs de proposer, modifier et supprimer des trajets, et aux administrateurs de gérer utilisateurs, agences et trajets.

Fonctionnalités principales

Tout utilisateur connecté :

Créer un trajet avec ses informations préremplies

Consulter la liste des trajets

Afficher les détails d’un trajet dans une modale (nom, email, téléphone, nombre de places)

Modifier et supprimer ses propres trajets

Administrateur :

Accéder au tableau de bord

Lister et gérer les utilisateurs

Lister, créer, modifier et supprimer les agences

Gérer tous les trajets

⚙️ Installation
1. Cloner le dépôt
git clone <lien-du-dépôt>
cd covoiturage

2. Base de données

Créer la base et les tables avec database/create_db.sql

Alimenter la base avec database/seed_db.sql

CREATE DATABASE covoiturage CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE covoiturage;

3. Configuration

Modifier config.php avec vos identifiants MySQL :

<?php
$host = 'localhost';
$dbname = 'covoiturage';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass);
session_start();

4. Lancer l’application

Placer le projet dans votre serveur local (ex : C:\wamp64\www\covoiturage)

Ouvrir http://localhost/covoiturage/

👥 Comptes de test
Rôle	Nom	Email	Mot de passe
Admin	Test Admin	admin@test.com
	password
Utilisateur	Martin Alexandre	alexandre.martin@email.fr
	password
Utilisateur	Sophie Dubois	sophie.dubois@email.fr
	password
🗂 Structure du projet
├── .htaccess
├── composer.json
├── composer.lock
├── config.php
├── create_user.php
├── helpers.php
├── index.php
├── package-lock.json
├── package.json
├── phpstan.neon
├── README.md
├── test_db.php
│
├── 📁 app/
│   ├── 📁 Controllers/
│   │   ├── AdminController.php
│   │   ├── TrajetController.php
│   │   └── Usercontroller.php
│   │
│   ├── 📁 Models/
│   │   ├── Agence.php
│   │   ├── Trajet.php
│   │   └── User.php
│   │
│   ├── 📁 Views/
│       ├── accueil.php
│       ├── admin_dashboard.php
│       ├── footer.php
│       ├── header.php
│       ├── login.php
│       ├── trajet_edit.php
│       └── trajet_form.php
│
├── 📁 assets/
│   ├── MCD.png
│   ├── MLD.txt
│   ├── 📁 jeu-d-essais/
│   │   ├── agences.csv
│   │   └── users.csv
│   │
│   ├── 📁 visuels/
│       ├── accueil.png
│       ├── details.png
│       ├── header_admin.png
│       ├── message_erreur.png
│       └── visiteur.png
│
├── 📁 database/
│   ├── create_db.sql
│   └── seed_db.sql
│
├── 📁 js/
│   └── main.js
│
├── 📁 public/
│   └── 📁 css/
│       ├── styles.css
│       ├── styles.css.map
│       ├── styles.scss
│       └── _variables.scss
│
├── 📁 tests/
│   ├── TrajetTest.php
│   └── UserTest.php
│
└── 📁 tools/
    ├── restore_claire.php
    └── update_passwords.php


📊 Modélisation

MCD : assets/visuels/MCD.png

MLD : assets/visuels/MLD.txt

📝 Notes importantes

Messages flash pour toutes les erreurs et confirmations.

Contrôles lors de la création d’un trajet :

Départ ≠ arrivée

Date arrivée > date départ

Actions critiques (modifier / supprimer) vérifient l’utilisateur connecté.
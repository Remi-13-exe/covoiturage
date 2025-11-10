<?php
/**
 * Point d'entrée principal de l'application.
 * Initialise la configuration, charge les contrôleurs et gère les routes.
 */

// 🔧 Inclusion des fichiers de configuration et des contrôleurs
require __DIR__ . '/config.php';
require __DIR__ . '/app/Controllers/TrajetController.php';
require __DIR__ . '/app/Controllers/UserController.php';
require __DIR__ . '/app/Controllers/AdminController.php';

// 🌐 Récupère l'URL demandée par le client
$request = $_SERVER['REQUEST_URI'];

// 🔍 Nettoyage de l'URL : suppression des paramètres GET
$path = parse_url($request, PHP_URL_PATH);

// 🧹 Retire le préfixe du projet si nécessaire (ex: /covoiturage)
$path = preg_replace('#^/covoiturage#', '', $path);

// ✂️ Supprime le slash final pour uniformiser
$path = rtrim($path, '/');

// 🏠 Normalise la racine (accueil)
if ($path === '' || $path === '/index.php') {
    $path = '/';
}

// 🧩 Instancie les contrôleurs
$trajetCtrl = new TrajetController();
$userCtrl = new UserController();
$adminCtrl = new AdminController();

// 🚦 Définition des routes
switch ($path) {

    // 🏠 Page d'accueil : liste des trajets
    case '/':
        $trajetCtrl->index();
        break;

    // 🔐 Connexion utilisateur
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCtrl->login();       // Traitement du formulaire
        } else {
            $userCtrl->loginForm();   // Affichage du formulaire
        }
        break;

    // ➕ Création d’un trajet
    case '/trajet/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetCtrl->create();       // Enregistrement du trajet
        } else {
            $trajetCtrl->createForm();   // Affichage du formulaire
        }
        break;

    // 🛠️ Tableau de bord administrateur
    case '/admin':
        $adminCtrl->index();
        break;

    // ❌ Route non trouvée
    default:
        http_response_code(404);
        echo "404 - Page non trouvée";
        break;
}

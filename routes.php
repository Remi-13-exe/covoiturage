<?php
// Inclut config et contrôleurs
require __DIR__ . '/config.php';
require __DIR__ . '/app/Controllers/TrajetController.php';
require __DIR__ . '/app/Controllers/UserController.php';
require __DIR__ . '/app/Controllers/AdminController.php';

// Récupère l'URL demandée
$request = $_SERVER['REQUEST_URI'];

// Retire les paramètres GET
$path = parse_url($request, PHP_URL_PATH);

// Retire le dossier du projet si nécessaire
$path = preg_replace('#^/covoiturage#', '', $path);

// Supprime le slash final
$path = rtrim($path, '/');

// Normalise la racine
if ($path === '' || $path === '/index.php') {
    $path = '/';
}

// Instancie les contrôleurs
$trajetCtrl = new TrajetController();
$userCtrl = new UserController();
$adminCtrl = new AdminController();

// Routes
switch ($path) {
    case '/':
        $trajetCtrl->index();
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCtrl->login();
        } else {
            $userCtrl->loginForm();
        }
        break;

    case '/trajet/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetCtrl->create();
        } else {
            $trajetCtrl->createForm();
        }
        break;

    case '/admin':
        $adminCtrl->index();
        break;

    default:
        http_response_code(404);
        echo "404 - Page non trouvée";
        break;
}

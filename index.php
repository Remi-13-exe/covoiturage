<?php
require __DIR__ . '/config.php';
require __DIR__ . '/app/Controllers/TrajetController.php';
require __DIR__ . '/app/Controllers/UserController.php';
require __DIR__ . '/app/Controllers/AdminController.php';

// Démarre la session **une seule fois**
session_start();

// Fonctions flash
function setFlash(string $message) {
    $_SESSION['flash'] = $message;
}

function getFlash(): ?string {
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return null;
}





// mini-routeur simple
$request = $_SERVER['REQUEST_URI'];

// Retire query string
$path = parse_url($request, PHP_URL_PATH);

// Retire le dossier du projet si nécessaire
$path = str_replace('/covoiturage', '', $path);
$path = rtrim($path, '/'); // supprime le slash final
if ($path === '') $path = '/';

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

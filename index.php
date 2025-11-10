<?php

/**
 * Point d'entrée principal de l'application.
 *
 * Initialise les dépendances, démarre la session, définit les fonctions utilitaires,
 * instancie les contrôleurs et gère les routes via un mini-routeur.
 */

// === Chargement des dépendances ===
require_once __DIR__ . '/helpers.php';
require __DIR__ . '/config.php';
require __DIR__ . '/app/Controllers/TrajetController.php';
require __DIR__ . '/app/Controllers/UserController.php';
require __DIR__ . '/app/Controllers/AdminController.php';

// === Démarrage de la session ===
if (!session_id()) session_start();

/**
 * Définit un message flash à afficher à l'utilisateur.
 *
 * @param string $message Le message à stocker temporairement
 * @return void
 */
function setFlash(string $message) {
    $_SESSION['flash'] = $message;
}

/**
 * Récupère et supprime le message flash stocké en session.
 *
 * @return string|null Le message flash ou null s'il n'existe pas
 */
function getFlash(): ?string {
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return null;
}

// === Mini-routeur simple basé sur l'URL ===
$request = $_SERVER['REQUEST_URI'];

// Nettoyage de l'URL : suppression des paramètres de requête
$path = parse_url($request, PHP_URL_PATH);

// Suppression du préfixe de dossier si nécessaire (ex: /covoiturage)
$path = str_replace('/covoiturage', '', $path);
$path = rtrim($path, '/'); // supprime le slash final
if ($path === '') $path = '/';

// === Instanciation des contrôleurs ===
$trajetCtrl = new TrajetController();
$userCtrl = new UserController();
$adminCtrl = new AdminController();

// === Définition des routes ===
switch (true) {

    // 🏠 Page d'accueil
    case ($path === '/'):
        $trajetCtrl->index();
        break;

    // 🔐 Connexion utilisateur
    case ($path === '/login'):
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userCtrl->login();
        } else {
            $userCtrl->loginForm();
        }
        break;

    // 🚪 Déconnexion utilisateur
    case ($path === '/logout'):
        session_destroy();
        header('Location: /covoiturage/login');
        exit;

    // ➕ Création d’un trajet
    case ($path === '/trajet/create'):
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetCtrl->create();
        } else {
            $trajetCtrl->createForm();
        }
        break;

    // 🗑️ Suppression d’un trajet
    case (preg_match('#^/trajet/delete/(\d+)$#', $path, $matches)):
        $id = (int)$matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetCtrl->delete($id);
        } else {
            echo "Méthode non autorisée.";
        }
        break;

    // ✏️ Modification d’un trajet
    case (preg_match('#^/trajet/edit/(\d+)$#', $path, $matches)):
        $id = (int)$matches[1];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $trajetCtrl->update($id, $_POST);
        } else {
            $trajetCtrl->editForm($id);
        }
        break;

    // 🛠️ Tableau de bord administrateur
    case ($path === '/admin'):
        $adminCtrl->index();
        break;

    // ❌ Route non trouvée
    default:
        http_response_code(404);
        echo "404 - Page non trouvée";
        break;
}

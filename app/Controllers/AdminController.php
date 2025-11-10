<?php

/**
 * Inclusion des fichiers de configuration et des modèles nécessaires.
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Trajet.php';
require_once __DIR__ . '/../Models/Agence.php';

/**
 * Contrôleur d'administration.
 *
 * Gère l'accès au tableau de bord administrateur et l'affichage des données globales.
 */
class AdminController {

    /**
     * Affiche le tableau de bord administrateur.
     *
     * Vérifie que l'utilisateur est connecté et possède le rôle "admin".
     * Charge les données des utilisateurs, trajets et agences pour affichage.
     *
     * @return void
     */
    public function index() {
        global $pdo;

        // Démarre la session si elle n'est pas déjà active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifie que l'utilisateur est un administrateur
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "<p style='color:red;'>⛔ Accès refusé : rôle administrateur requis.</p>";
            exit;
        }

        // Instanciation des modèles
        $userModel = new User($pdo);
        $trajetModel = new Trajet($pdo);
        $agenceModel = new Agence($pdo);

        // Récupération des données
        $users = $userModel->all();
        $trajets = $trajetModel->all();
        $agences = $agenceModel->all();

        // Affichage de la vue du tableau de bord
        include __DIR__ . '/../Views/admin_dashboard.php';
    }
}

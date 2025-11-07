<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Trajet.php';
require_once __DIR__ . '/../Models/Agence.php';

class AdminController {

    public function index() {
        global $pdo;

        // Vérifie si l'utilisateur est admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "<p style='color:red;'>⛔ Accès refusé : administrateur requis.</p>";
            exit;
        }

        $userModel = new User($pdo);
        $trajetModel = new Trajet($pdo);
        $agenceModel = new Agence($pdo);

        $users = $userModel->all();
        $trajets = $trajetModel->all();
        $agences = $agenceModel->all();

        include __DIR__ . '/../Views/admin_dashboard.php';
    }
}

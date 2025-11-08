<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/Trajet.php';
require_once __DIR__ . '/../Models/Agence.php';
require_once __DIR__ . '/../Models/User.php';

class TrajetController {

    // Vérifie que l'utilisateur est admin
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash'] = "❌ Accès refusé : rôle administrateur requis.";
            header('Location: /covoiturage/');
            exit;
        }
    }

    // Vérifie que l'utilisateur est connecté (tout rôle)
    private function checkUser() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash'] = "❌ Vous devez être connecté pour créer un trajet.";
            header('Location: /covoiturage/login');
            exit;
        }
    }

    // Affiche tous les trajets
    public function index() {
        global $pdo;
        $trajetModel = new Trajet($pdo);
        $trajets = $trajetModel->all();

        if (session_status() === PHP_SESSION_NONE) session_start();

        include __DIR__ . '/../Views/accueil.php';
    }

    // Formulaire de création de trajet → tout utilisateur connecté
    public function createForm() {
        $this->checkUser(); // ✅ tout utilisateur connecté
        global $pdo;
        $agenceModel = new Agence($pdo);
        $agences = $agenceModel->all();

        include __DIR__ . '/../Views/trajet_form.php';
    }

    // Création d’un trajet → tout utilisateur connecté
    public function create() {
        $this->checkUser();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            $user_id = $_SESSION['user']['id']; // id de l'utilisateur connecté
            $depart_id = $_POST['depart_id'];
            $arrivee_id = $_POST['arrivee_id'];
            $date_depart = $_POST['date_depart'];
            $date_arrivee = $_POST['date_arrivee'];
            $places_total = $_POST['places_total'];

            // Vérifications cohérentes
            if ($depart_id == $arrivee_id) {
                $_SESSION['flash'] = "❌ L'agence de départ et d'arrivée doivent être différentes !";
                header('Location: /covoiturage/trajet/create');
                exit;
            }

            if (strtotime($date_arrivee) <= strtotime($date_depart)) {
                $_SESSION['flash'] = "❌ La date d'arrivée doit être après la date de départ !";
                header('Location: /covoiturage/trajet/create');
                exit;
            }

            $agenceModel = new Agence($pdo);
            $agences = array_column($agenceModel->all(), 'id');
            if (!in_array($depart_id, $agences) || !in_array($arrivee_id, $agences)) {
                $_SESSION['flash'] = "❌ Agence de départ ou d'arrivée invalide !";
                header('Location: /covoiturage/trajet/create');
                exit;
            }

            // Création du trajet
            $trajetModel = new Trajet($pdo);
            $success = $trajetModel->create(
                $user_id,
                $depart_id,
                $arrivee_id,
                $date_depart,
                $date_arrivee,
                $places_total
            );

            $_SESSION['flash'] = $success
                ? "✅ Trajet créé avec succès !"
                : "❌ Erreur lors de la création du trajet !";

            header('Location: /covoiturage/');
            exit;
        }
    }

    // Édition et suppression → uniquement admin
    public function editForm($id) {
        $this->checkAdmin();
        global $pdo;

        $trajetModel = new Trajet($pdo);
        $trajet = $trajetModel->find($id);

        $agenceModel = new Agence($pdo);
        $agences = $agenceModel->all();

        include __DIR__ . '/../Views/trajet_edit.php';
    }

    public function update($id) {
        $this->checkAdmin();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart_id = $_POST['depart_id'];
            $arrivee_id = $_POST['arrivee_id'];
            $date_depart = $_POST['date_depart'];
            $date_arrivee = $_POST['date_arrivee'];

            // Vérifications cohérentes
            if ($depart_id == $arrivee_id) {
                $_SESSION['flash'] = "❌ L'agence de départ et d'arrivée doivent être différentes !";
                header("Location: /covoiturage/trajet/edit/$id");
                exit;
            }

            if (strtotime($date_arrivee) <= strtotime($date_depart)) {
                $_SESSION['flash'] = "❌ La date d'arrivée doit être après la date de départ !";
                header("Location: /covoiturage/trajet/edit/$id");
                exit;
            }

            $trajetModel = new Trajet($pdo);
            $success = $trajetModel->update(
                $id,
                $_POST['user_id'],
                $depart_id,
                $arrivee_id,
                $date_depart,
                $date_arrivee,
                $_POST['places_total']
            );

            $_SESSION['flash'] = $success
                ? "✏️ Trajet modifié avec succès !"
                : "❌ Erreur lors de la modification du trajet !";

            header('Location: /covoiturage/');
            exit;
        }
    }

    public function delete($id) {
        $this->checkAdmin();
        global $pdo;

        $trajetModel = new Trajet($pdo);
        $success = $trajetModel->delete($id);

        $_SESSION['flash'] = $success
            ? "🗑️ Trajet supprimé avec succès !"
            : "❌ Erreur lors de la suppression du trajet.";

        header('Location: /covoiturage/');
        exit;
    }
}

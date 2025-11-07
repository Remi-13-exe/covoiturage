<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/Trajet.php';
require_once __DIR__ . '/../Models/Agence.php';
require_once __DIR__ . '/../Models/User.php'; // pour vérifier les users

class TrajetController {

    public function index() {
        global $pdo;
        $trajetModel = new Trajet($pdo);
        $trajets = $trajetModel->all();

        // Debug : vérifier ce qui est récupéré
        // var_dump($trajets); exit;

        include __DIR__ . '/../Views/accueil.php';
    }

    public function createForm() {
        global $pdo;
        $agenceModel = new Agence($pdo);
        $agences = $agenceModel->all();
        include __DIR__ . '/../Views/trajet_form.php';
    }

    public function create() {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Vérification des IDs utilisateur et agences
            $user_id = $_POST['user_id'];
            $depart_id = $_POST['depart_id'];
            $arrivee_id = $_POST['arrivee_id'];
            $date_depart = $_POST['date_depart'];
            $date_arrivee = $_POST['date_arrivee'];
            $places_total = $_POST['places_total'];

            // Vérifie si l'user existe
            $userModel = new User($pdo);
            $users = array_column($userModel->all(), 'id');
            if (!in_array($user_id, $users)) {
                $_SESSION['flash'] = "❌ Utilisateur invalide !";
                header('Location: /covoiturage/trajet/create');
                exit;
            }

            // Vérifie si les agences existent
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

            // Flash message selon succès
            $_SESSION['flash'] = $success ? "✅ Trajet créé avec succès !" : "❌ Erreur lors de la création du trajet !";

            // Redirection vers la page d'accueil
            header('Location: /covoiturage/');
            exit;
        }
    }
}

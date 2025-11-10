<?php

/**
 * Inclusion des fichiers de configuration et des modèles nécessaires.
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/Trajet.php';
require_once __DIR__ . '/../Models/Agence.php';
require_once __DIR__ . '/../Models/User.php';

/**
 * Contrôleur de gestion des trajets.
 *
 * Gère les opérations liées aux trajets : affichage, création, modification, suppression.
 */
class TrajetController {

    /**
     * Vérifie que l'utilisateur connecté est un administrateur.
     *
     * Redirige vers la page d'accueil si l'utilisateur n'a pas le rôle 'admin'.
     *
     * @return void
     */
    private function checkAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash'] = "❌ Accès refusé : rôle administrateur requis.";
            header('Location: /covoiturage/');
            exit;
        }
    }

    /**
     * Vérifie que l'utilisateur est connecté, peu importe son rôle.
     *
     * Redirige vers la page de connexion si aucun utilisateur n'est connecté.
     *
     * @return void
     */
    private function checkUser() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['flash'] = "❌ Vous devez être connecté pour créer un trajet.";
            header('Location: /covoiturage/login');
            exit;
        }
    }

    /**
     * Affiche la liste de tous les trajets disponibles.
     *
     * @return void
     */
    public function index() {
        global $pdo;
        $trajetModel = new Trajet($pdo);
        $trajets = $trajetModel->all();

        if (session_status() === PHP_SESSION_NONE) session_start();

        include __DIR__ . '/../Views/accueil.php';
    }

    /**
     * Affiche le formulaire de création de trajet.
     *
     * Accessible à tout utilisateur connecté.
     *
     * @return void
     */
    public function createForm() {
        $this->checkUser();
        global $pdo;
        $agenceModel = new Agence($pdo);
        $agences = $agenceModel->all();

        include __DIR__ . '/../Views/trajet_form.php';
    }

    /**
     * Traite la création d’un nouveau trajet.
     *
     * Vérifie les données envoyées via POST et insère le trajet en base.
     *
     * @return void
     */
    public function create() {
        $this->checkUser();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            $user_id = $_SESSION['user']['id'];
            $depart_id = $_POST['depart_id'];
            $arrivee_id = $_POST['arrivee_id'];
            $date_depart = $_POST['date_depart'];
            $date_arrivee = $_POST['date_arrivee'];
            $places_total = $_POST['places_total'];

            // Vérifications de cohérence
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

    /**
     * Affiche le formulaire d'édition d’un trajet.
     *
     * Accessible uniquement aux administrateurs.
     *
     * @param int $id Identifiant du trajet à modifier
     * @return void
     */
    public function editForm($id) {
        $this->checkAdmin();
        global $pdo;

        $trajetModel = new Trajet($pdo);
        $trajet = $trajetModel->find($id);

        $agenceModel = new Agence($pdo);
        $agences = $agenceModel->all();

        include __DIR__ . '/../Views/trajet_edit.php';
    }

    /**
     * Met à jour les informations d’un trajet existant.
     *
     * Accessible uniquement aux administrateurs.
     *
     * @param int $id Identifiant du trajet à mettre à jour
     * @return void
     */
    public function update($id) {
        $this->checkAdmin();
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $depart_id = $_POST['depart_id'];
            $arrivee_id = $_POST['arrivee_id'];
            $date_depart = $_POST['date_depart'];
            $date_arrivee = $_POST['date_arrivee'];

            // Vérifications de cohérence
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

    /**
     * Supprime un trajet existant.
     *
     * Accessible uniquement aux administrateurs.
     *
     * @param int $id Identifiant du trajet à supprimer
     * @return void
     */
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

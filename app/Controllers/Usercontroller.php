<?php

/**
 * Inclusion des fichiers de configuration et du modèle utilisateur.
 */
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/User.php';

/**
 * Contrôleur de gestion des utilisateurs.
 *
 * Gère les opérations liées à l'authentification : affichage du formulaire, connexion, déconnexion.
 */
class UserController {

    /**
     * Affiche le formulaire de connexion.
     *
     * @return void
     */
    public function loginForm() {
        include __DIR__ . '/../Views/login.php';
    }

    /**
     * Traite la tentative de connexion d’un utilisateur.
     *
     * Vérifie les identifiants fournis via POST, initialise la session si les données sont valides,
     * et redirige vers la page d’accueil. En cas d’échec, affiche un message d’erreur.
     *
     * @return void
     */
    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $pdo;
        $userModel = new User($pdo);

        // Récupération des données du formulaire
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Recherche de l'utilisateur par email
        $user = $userModel->findByEmail($email);

        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            /**
             * Initialisation de la session utilisateur avec les données essentielles.
             * @var array $_SESSION['user']
             */
            $_SESSION['user'] = [
                'id'     => $user['id'],
                'nom'    => $user['nom'],
                'prenom' => $user['prenom'],
                'email'  => $user['email'],
                'role'   => $user['role']
            ];

            header('Location: /covoiturage/');
            exit;
        } else {
            // Affichage du formulaire avec message d’erreur
            $error = "❌ Identifiants invalides.";
            include __DIR__ . '/../Views/login.php';
        }
    }

    /**
     * Déconnecte l’utilisateur en cours.
     *
     * Vide la session et redirige vers la page de connexion.
     *
     * @return void
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Suppression des données de session
        $_SESSION = [];
        session_destroy();

        header('Location: /covoiturage/login');
        exit;
    }
}

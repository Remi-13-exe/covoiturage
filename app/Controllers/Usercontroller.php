<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/User.php';

class UserController {

    public function loginForm() {
        include __DIR__ . '/../Views/login.php';
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        global $pdo;
        $userModel = new User($pdo);

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Stocke uniquement les champs nécessaires
            $_SESSION['user'] = [
                'id'     => $user['id'],
                'nom'    => $user['nom'],
                'prenom' => $user['prenom'],
                'email'  => $user['email'],
                'role'   => $user['role'] // <- important
            ];

            header('Location: /covoiturage/');
            exit;
        } else {
            $error = "❌ Identifiants invalides.";
            include __DIR__ . '/../Views/login.php';
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Vide et détruit la session
        $_SESSION = [];
        session_destroy();

        header('Location: /covoiturage/login');
        exit;
    }
}

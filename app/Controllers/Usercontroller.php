<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../Models/User.php';

class UserController {

    public function loginForm() {
        include __DIR__ . '/../Views/login.php';
    }

    public function login() {
        global $pdo;
        session_start();

        $userModel = new User($pdo);
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header('Location: /covoiturage/');
            exit;
        } else {
            echo "<p style='color:red;'>❌ Identifiants invalides.</p>";
            include __DIR__ . '/../Views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /covoiturage/login');
        exit;
    }
}

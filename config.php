<?php
// =======================
// CONFIGURATION DE LA BASE
// =======================

define('DB_HOST', 'localhost');
define('DB_NAME', 'covoiturage');
define('DB_USER', 'root');
define('DB_PASS', ''); // ou ton mot de passe MySQL si tu en as mis un

try {
    // Connexion PDO
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // erreurs en exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // fetch en tableau associatif
        ]
    );
} catch (PDOException $e) {
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}

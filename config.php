<?php

/**
 * Fichier de configuration de la base de données pour le projet Covoiturage.
 *
 * Ce fichier :
 * - Définit les constantes de connexion (hôte, nom de base, identifiants).
 * - Initialise une connexion PDO avec gestion des erreurs.
 * - Est utilisé dans tous les scripts nécessitant un accès à la base.
 *
 * ⚠️ À ne jamais exposer publiquement. Pense à sécuriser les identifiants en production.
 *
 * @package config
 * @author remi
 */

// =======================
// CONFIGURATION DE LA BASE
// =======================

define('DB_HOST', 'localhost');
define('DB_NAME', 'covoiturage');
define('DB_USER', 'root');
define('DB_PASS', ''); // ou ton mot de passe MySQL si tu en as mis un

try {
    // 🔌 Connexion PDO
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // erreurs en exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC   // fetch en tableau associatif
        ]
    );
} catch (PDOException $e) {
    // ❌ Gestion des erreurs de connexion
    die("❌ Erreur de connexion à la base de données : " . $e->getMessage());
}

<?php

/**
 * Script de test manuel pour afficher la liste des utilisateurs.
 *

 *
 * Fonctionnement :
 * - Initialise la configuration PDO.
 * - Instancie le modèle User.
 * - Récupère tous les utilisateurs.
 * - Affiche leur prénom, nom et email en HTML brut.
 *
 * Usage : php tools/test_users.php ou via navigateur si intégré dans une vue.
 *
 * @package tools
 * @author remi
 */

// 🔧 Inclusion de la configuration et du modèle User
require __DIR__ . '/../config.php';
require __DIR__ . '/../app/Models/User.php';

// 🧩 Instanciation du modèle
$userModel = new User($pdo);

// 📥 Récupération des utilisateurs
$users = $userModel->all();

// 🖨️ Affichage des résultats
echo "<h2>👥 Liste des utilisateurs :</h2>";
foreach ($users as $u) {
    echo htmlspecialchars("{$u['prenom']} {$u['nom']} ({$u['email']})") . "<br>";
}

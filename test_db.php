<?php

/**
 * Script de test manuel de la connexion à la base de données.
 *
 * - la connexion PDO à la base 'covoiturage',
 * - la présence de la table `users`,
 * - le nombre d'utilisateurs enregistrés.
 *
 * 
 *
 * Usage : php testdb.php ou via navigateur si intégré dans une vue.
 *
 * @package tools
 * @author remi
 */

// 🔧 Inclusion de la configuration PDO
require_once 'config.php';

try {
    // 📥 Requête simple pour compter les utilisateurs
    $stmt = $pdo->query("SELECT COUNT(*) AS nb_users FROM users");
    $row = $stmt->fetch();

    // ✅ Affichage du résultat
    echo "✅ Connexion réussie à la base 'covoiturage' !<br>";
    echo "👥 Nombre d’utilisateurs trouvés : " . $row['nb_users'];
} catch (Exception $e) {
    // ❌ Gestion des erreurs
    echo "❌ Erreur : " . $e->getMessage();
}

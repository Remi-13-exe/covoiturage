<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT COUNT(*) AS nb_users FROM users");
    $row = $stmt->fetch();
    echo "✅ Connexion réussie à la base 'covoiturage' !<br>";
    echo "👥 Nombre d’utilisateurs trouvés : " . $row['nb_users'];
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage();
}

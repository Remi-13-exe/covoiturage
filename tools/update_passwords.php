<?php

/**
 * Script CLI pour mettre à jour les mots de passe des utilisateurs.
 *
 * Usage : php tools/update_passwords.php [nouveauMotDePasse]
 *
 * Ce script :
 * - Hash tous les mots de passe des utilisateurs en bcrypt.
 * - Ignore certains comptes définis dans $excludeEmails.
 * - Permet de passer un mot de passe personnalisé en argument.
 *
 * @package tools
 */

// 🔧 Inclusion de la configuration PDO
require_once __DIR__ . '/../config.php'; // adapte le chemin si nécessaire

// 🔐 Mot de passe par défaut (modifiable via argument CLI)
$newPassword = 'password123';

// 📛 Liste des emails à exclure de la mise à jour
$excludeEmails = [
    'test.user@mail.com'  // ne pas toucher à ce compte
];

// 🧾 Permet de passer un mot de passe personnalisé en argument
if (isset($argv[1]) && trim($argv[1]) !== '') {
    $newPassword = $argv[1];
}

echo "Mise à jour des mots de passe (nouveau mot de passe = '{$newPassword}')\n";

try {
    // 📥 Récupère tous les utilisateurs
    $stmt = $pdo->query("SELECT id, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 🔄 Prépare la requête de mise à jour
    $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");

    $count = 0;

    // 🔁 Parcours des utilisateurs
    foreach ($users as $u) {
        // ⛔ Ignore les comptes exclus
        if (in_array($u['email'], $excludeEmails, true)) {
            echo "Skip {$u['email']} (exclu)\n";
            continue;
        }

        // 🔐 Hash du mot de passe
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        // 💾 Mise à jour en base
        $updateStmt->execute([
            ':password' => $hash,
            ':id' => $u['id']
        ]);

        echo "Updated user id {$u['id']} ({$u['email']})\n";
        $count++;
    }

    // ✅ Résumé final
    echo "\nOK — $count comptes mis à jour.\n";
    echo "Identifiants de test : email = <email utilisateur>, mot de passe = {$newPassword}\n";

} catch (PDOException $e) {
    // ❌ Gestion des erreurs PDO
    echo "Erreur PDO : " . $e->getMessage() . "\n";
    exit(1);
}

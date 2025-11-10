<?php
// tools/update_passwords.php
// Usage : php tools/update_passwords.php
// Modifie les mots de passe des users (sauf l'utilisateur test.user@mail.com) en bcrypt

require_once __DIR__ . '/../config.php'; // adapte le chemin si nécessaire

// Nouveau mot de passe par défaut (change si besoin)
$newPassword = 'password123';

// Emails à exclure (ne pas modifier) — ajoute ici d'autres si besoin
$excludeEmails = [
    'test.user@mail.com'  // ne pas toucher à ce compte
];

// Si tu veux fournir un mot de passe en ligne de commande : php tools/update_passwords.php monNouveauPass
if (isset($argv[1]) && trim($argv[1]) !== '') {
    $newPassword = $argv[1];
}

echo "Mise à jour des mots de passe (nouveau mot de passe = '{$newPassword}')\n";

try {
    // Récupère tous les utilisateurs
    $stmt = $pdo->query("SELECT id, email FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");

    $count = 0;
    foreach ($users as $u) {
        if (in_array($u['email'], $excludeEmails, true)) {
            echo "Skip {$u['email']} (exclu)\n";
            continue;
        }

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt->execute([
            ':password' => $hash,
            ':id' => $u['id']
        ]);
        echo "Updated user id {$u['id']} ({$u['email']})\n";
        $count++;
    }

    echo "\nOK — $count comptes mis à jour.\n";
    echo "Identifiants de test : email = <email utilisateur>, mot de passe = {$newPassword}\n";
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage() . "\n";
    exit(1);
}

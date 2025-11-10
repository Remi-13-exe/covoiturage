<?php
// tools/restore_claire.php
// Usage : php tools/restore_claire.php [nouveauMotDePasse]
// Si aucun mot de passe fourni, utilisera "admin123" par défaut.

require_once __DIR__ . '/../config.php';

$email = 'claire.martin@mail.com';
$newPassword = $argv[1] ?? 'admin123';

try {
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
    $stmt->execute([':password' => $hash, ':email' => $email]);

    if ($stmt->rowCount() > 0) {
        echo "OK — mot de passe de {$email} mis à jour (nouveau mot de passe = '{$newPassword}').\n";
    } else {
        echo "Aucun utilisateur trouvé pour {$email} (rien modifié).\n";
    }
} catch (PDOException $e) {
    echo "Erreur PDO : " . $e->getMessage() . "\n";
    exit(1);
}

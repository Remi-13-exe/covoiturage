<?php
require __DIR__ . '/config.php'; // Connexion $pdo

// ----------------------
// CONFIGURATION UTILISATEUR
// ----------------------
$nom = 'Test';
$prenom = 'User';
$telephone = '0622222222';
$email = 'test.user@mail.com';
$motdepasse = 'test123'; // mot de passe en clair
$role = 'user'; // rôle utilisateur normal

// Hash du mot de passe
$hash = password_hash($motdepasse, PASSWORD_DEFAULT);

// Vérifie si l'utilisateur existe déjà
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
if ($stmt->fetch()) {
    die("❌ L'utilisateur avec l'email $email existe déjà !");
}

// Insertion dans la base
$stmt = $pdo->prepare("
    INSERT INTO users (nom, prenom, telephone, email, password, role)
    VALUES (:nom, :prenom, :telephone, :email, :password, :role)
");

$result = $stmt->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':telephone' => $telephone,
    ':email' => $email,
    ':password' => $hash,
    ':role' => $role
]);

if ($result) {
    echo "✅ Utilisateur créé avec succès !\n";
    echo "Email : $email\nMot de passe : $motdepasse\n";
} else {
    echo "❌ Erreur lors de la création de l'utilisateur.\n";
}

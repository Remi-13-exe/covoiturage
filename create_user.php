<?php

/**
 * Inclusion du fichier de configuration.
 *
 * Initialise la connexion PDO à la base de données.
 */
require __DIR__ . '/config.php'; // Connexion $pdo

// ----------------------
// CONFIGURATION UTILISATEUR
// ----------------------

/**
 * Nom de l'utilisateur.
 * @var string
 */
$nom = 'Test';

/**
 * Prénom de l'utilisateur.
 * @var string
 */
$prenom = 'User';

/**
 * Numéro de téléphone de l'utilisateur.
 * @var string
 */
$telephone = '0622222222';

/**
 * Adresse email de l'utilisateur.
 * @var string
 */
$email = 'test.user@mail.com';

/**
 * Mot de passe en clair.
 * @var string
 */
$motdepasse = 'test123';

/**
 * Rôle attribué à l'utilisateur.
 * @var string
 */
$role = 'user';

/**
 * Hash du mot de passe.
 * Utilise l'algorithme par défaut (actuellement BCRYPT).
 * @var string
 */
$hash = password_hash($motdepasse, PASSWORD_DEFAULT);

/**
 * Préparation de la requête pour vérifier si l'utilisateur existe déjà.
 * @var PDOStatement
 */
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");

/**
 * Exécution de la requête avec l'email fourni.
 */
$stmt->execute([':email' => $email]);

/**
 * Vérifie si un utilisateur avec cet email existe déjà.
 * Si oui, le script s'arrête.
 */
if ($stmt->fetch()) {
    die("❌ L'utilisateur avec l'email $email existe déjà !");
}

/**
 * Préparation de la requête d'insertion dans la base de données.
 */
$stmt = $pdo->prepare("
    INSERT INTO users (nom, prenom, telephone, email, password, role)
    VALUES (:nom, :prenom, :telephone, :email, :password, :role)
");

/**
 * Exécution de la requête avec les données utilisateur.
 * @var bool
 */
$result = $stmt->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':telephone' => $telephone,
    ':email' => $email,
    ':password' => $hash,
    ':role' => $role
]);

/**
 * Affichage du résultat de la création.
 */
if ($result) {
    echo "✅ Utilisateur créé avec succès !\n";
    echo "Email : $email\nMot de passe : $motdepasse\n";
} else {
    echo "❌ Erreur lors de la création de l'utilisateur.\n";
}

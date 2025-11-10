<?php

/**
 * 1_ Définition du mot de passe à hasher.
 *
 * @var string $password Le mot de passe en clair à sécuriser.
 */
$password = 'test123'; // le mot de passe que tu veux utiliser

/**
 * 2_ Génération du hash sécurisé du mot de passe.
 *
 * Utilise l'algorithme par défaut de PHP (actuellement BCRYPT).
 *
 * @var string $hash Le mot de passe hashé.
 */
$hash = password_hash($password, PASSWORD_DEFAULT);

/**
 * 1_ Affichage du mot de passe original.
 */
echo "Mot de passe : $password\n";

/**
 * 2_ Affichage du hash généré.
 */
echo "Hash : $hash\n";

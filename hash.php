<?php
$password = 'test123'; // le mot de passe que tu veux utiliser
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Mot de passe : $password\n";
echo "Hash : $hash\n";

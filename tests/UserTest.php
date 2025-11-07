<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../app/Models/User.php';

$userModel = new User($pdo);
$users = $userModel->all();

echo "<h2>👥 Liste des utilisateurs :</h2>";
foreach ($users as $u) {
    echo "{$u['prenom']} {$u['nom']} ({$u['email']})<br>";
}

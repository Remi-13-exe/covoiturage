<?php
// hash.php - Génère un hash pour un mot de passe (supprimez ce fichier après usage !)

// Choisis ici le mot de passe que tu veux pour l'admin
$plain = 'admin123'; // <-- change ce mot de passe si tu veux

$hash = password_hash($plain, PASSWORD_DEFAULT);

echo "<p>Mot de passe choisi : <b>" . htmlspecialchars($plain) . "</b></p>";
echo "<p>Hash à copier dans la DB :</p>";
echo "<pre>" . $hash . "</pre>";

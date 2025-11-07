<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../app/Models/Agence.php';

$agenceModel = new Agence($pdo);
$agences = $agenceModel->all();

echo "<h2>🏢 Liste des agences :</h2>";
foreach ($agences as $a) {
    echo "- {$a['id']}: {$a['nom']}<br>";
}

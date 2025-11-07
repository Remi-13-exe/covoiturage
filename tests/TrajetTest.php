<?php
require __DIR__ . '/../config.php';
require __DIR__ . '/../app/Models/Trajet.php';

$trajetModel = new Trajet($pdo);
$trajets = $trajetModel->all();

echo "<h2>🚗 Liste des trajets disponibles :</h2>";

foreach ($trajets as $t) {
    echo "<b>{$t['conducteur']}</b> — {$t['depart']} → {$t['arrivee']}<br>";
    echo "🕓 Départ : {$t['date_depart']} — Arrivée : {$t['date_arrivee']}<br>";
    echo "Places : {$t['places_dispo']}/{$t['places_total']}<hr>";
}

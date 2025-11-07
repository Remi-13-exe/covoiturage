<?php include 'header.php'; ?>

<h1 class="mb-4">🛠️ Tableau de bord Admin</h1>

<h3>👥 Utilisateurs</h3>
<ul>
    <?php foreach($users as $u): ?>
        <li><?= htmlspecialchars($u['prenom']) ?> <?= htmlspecialchars($u['nom']) ?> (<?= $u['role'] ?>)</li>
    <?php endforeach; ?>
</ul>

<h3>🚗 Trajets</h3>
<ul>
    <?php foreach($trajets as $t): ?>
        <li><?= $t['conducteur'] ?> : <?= $t['depart'] ?> → <?= $t['arrivee'] ?> (<?= $t['places_dispo'] ?>/<?= $t['places_total'] ?>)</li>
    <?php endforeach; ?>
</ul>

<h3>🏢 Agences</h3>
<ul>
    <?php foreach($agences as $a): ?>
        <li><?= htmlspecialchars($a['nom']) ?></li>
    <?php endforeach; ?>
</ul>

<?php include 'footer.php'; ?>

<?php include __DIR__ . '/header.php'; ?>

<?php if ($msg = getFlash()): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<div class="container mt-4">
    <h1 class="mb-4">🚗 Liste des trajets disponibles</h1>

    <?php if (empty($trajets)): ?>
        <p>Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($trajets as $t): ?>
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars($t['depart']) ?> → <?= htmlspecialchars($t['arrivee']) ?>
                            </h5>
                            <p class="card-text">
                                Conducteur : <b><?= htmlspecialchars($t['conducteur']) ?></b><br>
                                Départ : <?= htmlspecialchars($t['date_depart']) ?><br>
                                Arrivée : <?= htmlspecialchars($t['date_arrivee']) ?><br>
                                Places : <?= htmlspecialchars($t['places_dispo']) ?>/<?= htmlspecialchars($t['places_total']) ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>

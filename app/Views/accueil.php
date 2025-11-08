<?php include __DIR__ . '/header.php'; ?>

<?php if ($msg = getFlash()): ?>
    <div class="alert alert-success mt-3"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<!-- Conteneur principal avec un grand espace vertical -->
<div class="container" style="margin-top: 150px; margin-bottom: 150px;">
    <h1 class="mb-4">🚗 Liste des trajets disponibles</h1>

    <?php if (empty($trajets)): ?>
        <p>Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Conducteur</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date départ</th>
                        <th>Date arrivée</th>
                        <th>Places dispo / total</th>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trajets as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['id']) ?></td>
                            <td><?= htmlspecialchars($t['conducteur']) ?></td>
                            <td><?= htmlspecialchars($t['depart']) ?></td>
                            <td><?= htmlspecialchars($t['arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['date_depart']) ?></td>
                            <td><?= htmlspecialchars($t['date_arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['places_dispo']) ?>/<?= htmlspecialchars($t['places_total']) ?></td>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                                <td>
                                    <a href="/covoiturage/trajet/edit/<?= $t['id'] ?>" class="btn btn-primary btn-sm me-1">Modifier</a>
                                    <form action="/covoiturage/trajet/delete/<?= $t['id'] ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?');">Supprimer</button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/footer.php'; ?>

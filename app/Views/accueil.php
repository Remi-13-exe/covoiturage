<?php 
/**
 * Inclusion du header contenant la navbar et les balises <head>.
 */
include __DIR__ . '/header.php'; 
?>

<?php 
/**
 * Affiche un message flash si présent en session.
 */
if ($msg = getFlash()): ?>
    <div class="alert alert-success mt-3"><?= htmlspecialchars($msg) ?></div>
<?php endif; ?>

<!-- 🧭 Conteneur principal avec marges verticales -->
<div class="container" style="margin-top: 150px; margin-bottom: 150px;">
    <!-- Titre principal -->
    <h1 class="mb-5 text-primary fw-bold">🚗 Liste des trajets disponibles</h1>

    <?php if (empty($trajets)): ?>
        <!-- Message si aucun trajet n'est disponible -->
        <p>Aucun trajet disponible pour le moment.</p>
    <?php else: ?>
        <!-- Tableau responsive des trajets -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle shadow-sm">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Conducteur</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Date départ</th>
                        <th>Date arrivée</th>
                        <th>Places dispo / total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($trajets as $t): ?>
                        <tr>
                            <!-- Données du trajet -->
                            <td><?= htmlspecialchars($t['id']) ?></td>
                            <td><?= htmlspecialchars($t['conducteur']) ?></td>
                            <td><?= htmlspecialchars($t['depart']) ?></td>
                            <td><?= htmlspecialchars($t['arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['date_depart']) ?></td>
                            <td><?= htmlspecialchars($t['date_arrivee']) ?></td>
                            <td><?= htmlspecialchars($t['places_dispo']) ?>/<?= htmlspecialchars($t['places_total']) ?></td>
                            <td class="text-center">

                                <!-- Bouton pour afficher les détails dans une modale -->
                                <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                        data-bs-target="#detailsModal<?= $t['id'] ?>">
                                    ℹ️ Détails
                                </button>

                                <!-- Boutons modifier/supprimer si l'utilisateur est le créateur -->
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $t['user_id']): ?>
                                    <a href="/covoiturage/trajet/edit/<?= $t['id'] ?>" class="btn btn-warning btn-sm text-dark">✏️ Modifier</a>

                                    <form action="/covoiturage/trajet/delete/<?= $t['id'] ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer ce trajet ?');">🗑️ Supprimer</button>
                                    </form>
                                <?php endif; ?>

                                <!-- Bouton supprimer aussi accessible à l'admin -->
                                <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin' && $_SESSION['user']['id'] != $t['user_id']): ?>
                                    <form action="/covoiturage/trajet/delete/<?= $t['id'] ?>" method="post" style="display:inline;">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Supprimer ce trajet ?');">🗑️ Supprimer</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- 🔍 Modale affichant les détails du trajet -->
                        <div class="modal fade" id="detailsModal<?= $t['id'] ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">🚘 Détails du trajet #<?= $t['id'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Conducteur :</strong> <?= htmlspecialchars($t['conducteur']) ?></p>
                                        <p><strong>Email :</strong> <?= htmlspecialchars($t['email'] ?? 'Non renseigné') ?></p>
                                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($t['tel'] ?? 'Non renseigné') ?></p>
                                        <hr>
                                        <p><strong>Départ :</strong> <?= htmlspecialchars($t['depart']) ?></p>
                                        <p><strong>Arrivée :</strong> <?= htmlspecialchars($t['arrivee']) ?></p>
                                        <p><strong>Date départ :</strong> <?= htmlspecialchars($t['date_depart']) ?></p>
                                        <p><strong>Date arrivée :</strong> <?= htmlspecialchars($t['date_arrivee']) ?></p>
                                        <p><strong>Places totales :</strong> <?= htmlspecialchars($t['places_total']) ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 🔚 Fin de la modale -->

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php 
/**
 * Inclusion du footer contenant les balises de fermeture HTML.
 */
include __DIR__ . '/footer.php'; 
?>

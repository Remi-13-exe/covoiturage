<?php 
/**
 * Inclusion du header contenant la navbar et les balises <head>.
 */
/**
 * @var array<int, array<string, mixed>> $users
 * @var array<int, array<string, mixed>> $agences
 * @var array<int, array<string, mixed>> $trajets
 */



include 'header.php'; 
?>

<!-- 🧭 Conteneur principal -->
<div class="container mt-4">
    <!-- Titre principal -->
    <h1 class="mb-4 text-primary">🛠️ Tableau de bord Admin</h1>

    <!-- 👥 Section : Liste des utilisateurs -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            👥 Utilisateurs
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $u): ?>
                        <tr>
                            <td><?= $u['id'] ?></td>
                            <td><?= htmlspecialchars($u['nom']) ?></td>
                            <td><?= htmlspecialchars($u['prenom']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['role']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🏢 Section : Liste des agences -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            🏢 Agences
            <!-- Bouton d'ajout d'agence -->
            <a href="/covoiturage/agence/create" class="btn btn-light btn-sm">➕ Ajouter agence</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($agences as $a): ?>
                        <tr>
                            <td><?= $a['id'] ?></td>
                            <td><?= htmlspecialchars($a['nom']) ?></td>
                            <td>
                                <!-- Bouton modifier agence -->
                                <a href="/covoiturage/agence/edit/<?= $a['id'] ?>" class="btn btn-primary btn-sm me-1">Modifier</a>
                                <!-- Formulaire suppression agence -->
                                <form action="/covoiturage/agence/delete/<?= $a['id'] ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette agence ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🚗 Section : Liste des trajets -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            🚗 Trajets
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Conducteur</th>
                        <th>Départ</th>
                        <th>Arrivée</th>
                        <th>Places dispo / total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($trajets as $t): ?>
                        <tr>
                            <td><?= $t['id'] ?></td>
                            <td><?= htmlspecialchars($t['conducteur']) ?></td>
                            <td><?= htmlspecialchars($t['depart']) ?></td>
                            <td><?= htmlspecialchars($t['arrivee']) ?></td>
                            <td><?= $t['places_dispo'] ?>/<?= $t['places_total'] ?></td>
                            <td>
                                <!-- Bouton modifier trajet -->
                                <a href="/covoiturage/trajet/edit/<?= $t['id'] ?>" class="btn btn-primary btn-sm me-1">Modifier</a>
                                <!-- Formulaire suppression trajet -->
                                <form action="/covoiturage/trajet/delete/<?= $t['id'] ?>" method="post" style="display:inline;">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce trajet ?');">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
/**
 * Inclusion du footer contenant les balises de fermeture HTML.
 */
include 'footer.php'; 
?>

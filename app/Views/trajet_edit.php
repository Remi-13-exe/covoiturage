<?php 
/**
 * Inclusion de l'en-tête HTML commun à toutes les pages.
 */
include __DIR__ . '/header.php'; 
?>

<div class="container mt-4">
    <!-- Titre principal de la page -->
    <h1 class="mb-4">✏️ Modifier le trajet</h1>

    <?php 
    /**
     * Affiche un message flash si présent en session.
     */
    if ($msg = getFlash()): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <!-- Formulaire de modification du trajet -->
    <form method="post" action="/covoiturage/trajet/edit/<?= $trajet['id'] ?>" class="w-50">
        
        <!-- Champ : ID du conducteur -->
        <div class="mb-3">
            <label for="user_id" class="form-label">ID Conducteur</label>
            <input type="number" name="user_id" id="user_id" class="form-control" 
                   value="<?= htmlspecialchars($trajet['user_id']) ?>" required>
        </div>

        <!-- Champ : Agence de départ -->
        <div class="mb-3">
            <label for="depart_id" class="form-label">Départ</label>
            <select name="depart_id" id="depart_id" class="form-select">
                <?php foreach($agences as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= $trajet['depart_id'] == $a['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Champ : Agence d'arrivée -->
        <div class="mb-3">
            <label for="arrivee_id" class="form-label">Arrivée</label>
            <select name="arrivee_id" id="arrivee_id" class="form-select">
                <?php foreach($agences as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= $trajet['arrivee_id'] == $a['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($a['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Champ : Date et heure de départ -->
        <div class="mb-3">
            <label for="date_depart" class="form-label">Date départ</label>
            <input type="datetime-local" name="date_depart" id="date_depart" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_depart'])) ?>" required>
        </div>

        <!-- Champ : Date et heure d'arrivée -->
        <div class="mb-3">
            <label for="date_arrivee" class="form-label">Date arrivée</label>
            <input type="datetime-local" name="date_arrivee" id="date_arrivee" class="form-control" 
                   value="<?= date('Y-m-d\TH:i', strtotime($trajet['date_arrivee'])) ?>" required>
        </div>

        <!-- Champ : Nombre total de places -->
        <div class="mb-3">
            <label for="places_total" class="form-label">Nombre de places</label>
            <input type="number" name="places_total" id="places_total" class="form-control" 
                   value="<?= htmlspecialchars($trajet['places_total']) ?>" required>
        </div>

        <!-- Boutons d'action -->
        <button type="submit" class="btn btn-primary">Modifier le trajet</button>
        <a href="/covoiturage/" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php 
/**
 * Inclusion du pied de page HTML commun.
 */
include __DIR__ . '/footer.php'; 
?>

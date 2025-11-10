<?php 
/**
 * Inclusion du header contenant la navbar et les balises <head>.
 */
include 'header.php'; 
?>

<?php 
/**
 * Affiche un message flash si présent en session.
 * Utilise une alerte Bootstrap : rouge si erreur (❌), vert si succès.
 */
if ($msg = getFlash()): ?>
    <div class="alert alert-<?= strpos($msg, '❌') !== false ? 'danger' : 'success' ?>">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?>

<!-- 🧭 Titre dynamique selon le contexte (création ou modification) -->
<h1 class="mb-4"><?= isset($trajet) ? '✏️ Modifier un trajet' : '➕ Créer un trajet' ?></h1>

<?php
/**
 * Récupère les informations de l'utilisateur connecté depuis la session.
 */
$user = $_SESSION['user'] ?? null;
?>

<!-- 📝 Formulaire de création ou modification de trajet -->
<form method="post" action="<?= isset($trajet) ? '/covoiturage/trajet/edit/'.$trajet['id'] : '/covoiturage/trajet/create' ?>" class="w-50">

    <?php if ($user): ?>
        <!-- Informations utilisateur affichées mais non modifiables -->
        <div class="mb-3">
            <label class="form-label">Nom et prénom</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars(($user['prenom'] ?? '').' '.($user['nom'] ?? '')) ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['tel'] ?? '') ?>" disabled>
        </div>

        <!-- ID utilisateur caché pour lier le trajet -->
        <input type="hidden" name="user_id" value="<?= $user['id'] ?? '' ?>">
    <?php endif; ?>

    <!-- Sélection de l'agence de départ -->
    <div class="mb-3">
        <label for="depart_id" class="form-label">Départ</label>
        <select name="depart_id" id="depart_id" class="form-select" required>
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>" <?= (isset($trajet) && $trajet['depart_id'] == $a['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Sélection de l'agence d'arrivée -->
    <div class="mb-3">
        <label for="arrivee_id" class="form-label">Arrivée</label>
        <select name="arrivee_id" id="arrivee_id" class="form-select" required>
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>" <?= (isset($trajet) && $trajet['arrivee_id'] == $a['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($a['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Date et heure de départ -->
    <div class="mb-3">
        <label for="date_depart" class="form-label">Date départ</label>
        <input type="datetime-local" name="date_depart" id="date_depart" class="form-control"
               value="<?= isset($trajet) ? date('Y-m-d\TH:i', strtotime($trajet['date_depart'])) : '' ?>" required>
    </div>

    <!-- Date et heure d'arrivée -->
    <div class="mb-3">
        <label for="date_arrivee" class="form-label">Date arrivée</label>
        <input type="datetime-local" name="date_arrivee" id="date_arrivee" class="form-control"
               value="<?= isset($trajet) ? date('Y-m-d\TH:i', strtotime($trajet['date_arrivee'])) : '' ?>" required>
    </div>

    <!-- Nombre total de places -->
    <div class="mb-3">
        <label for="places_total" class="form-label">Nombre de places</label>
        <input type="number" name="places_total" id="places_total" class="form-control"
               value="<?= isset($trajet) ? $trajet['places_total'] : '' ?>" required>
    </div>

    <?php if (isset($trajet)): ?>
        <!-- Nombre de places disponibles (modification uniquement) -->
        <div class="mb-3">
            <label for="places_dispo" class="form-label">Places disponibles</label>
            <input type="number" name="places_dispo" id="places_dispo" class="form-control"
                   value="<?= $trajet['places_dispo'] ?>" required>
        </div>
    <?php endif; ?>

    <!-- Bouton d'envoi du formulaire -->
    <button type="submit" class="btn btn-<?= isset($trajet) ? 'primary' : 'success' ?>">
        <?= isset($trajet) ? 'Modifier le trajet' : 'Créer le trajet' ?>
    </button>
</form>

<?php 
/**
 * Inclusion du footer contenant les balises de fermeture HTML.
 */
include 'footer.php'; 
?>

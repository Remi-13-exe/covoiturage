<?php include 'header.php'; ?>

<h1 class="mb-4">➕ Créer un trajet</h1>

<form method="post" action="/covoiturage/trajet/create" class="w-50">
    <div class="mb-3">
        <label for="user_id" class="form-label">ID Conducteur</label>
        <input type="number" name="user_id" id="user_id" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="depart_id" class="form-label">Départ</label>
        <select name="depart_id" id="depart_id" class="form-select">
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="arrivee_id" class="form-label">Arrivée</label>
        <select name="arrivee_id" id="arrivee_id" class="form-select">
            <?php foreach($agences as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['nom']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="date_depart" class="form-label">Date départ</label>
        <input type="datetime-local" name="date_depart" id="date_depart" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="date_arrivee" class="form-label">Date arrivée</label>
        <input type="datetime-local" name="date_arrivee" id="date_arrivee" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="places_total" class="form-label">Nombre de places</label>
        <input type="number" name="places_total" id="places_total" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Créer le trajet</button>
</form>

<?php include 'footer.php'; ?>

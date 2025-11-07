<?php include 'header.php'; ?>

<h1 class="mb-4">🔑 Connexion</h1>

<form method="post" action="/covoiturage/login" class="w-50">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>

<?php include 'footer.php'; ?>

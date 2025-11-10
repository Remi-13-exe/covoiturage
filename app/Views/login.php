<?php 
/**
 * Inclusion du header contenant la navbar et les balises <head>.
 */
include __DIR__ . '/header.php'; 
?>

<!-- 🧭 Conteneur principal -->
<div class="container mt-4">
    <!-- Titre de la page -->
    <h1>Connexion</h1>

    <?php 
    /**
     * Affiche un message d'erreur si la variable $error est définie.
     * Utilise une alerte Bootstrap rouge pour signaler l'échec.
     */
    if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- 📝 Formulaire de connexion -->
    <form method="post" action="/covoiturage/login">
        <!-- Champ email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Champ mot de passe -->
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Bouton d'envoi -->
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php 
/**
 * Inclusion du footer contenant les balises de fermeture HTML.
 */
include __DIR__ . '/footer.php'; 
?>

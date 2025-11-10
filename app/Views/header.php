<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Covoiturage</title>

    <!-- Feuille de style principale -->
    <link href="/covoiturage/public/css/styles.css" rel="stylesheet">

    <!-- Bootstrap JS bundle (inclut Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* 🔠 Style du gros titre dans la navbar */
        .navbar-brand-gros-titre {
            font-size: 3.5rem;            
            font-weight: 900;             
            color: #f1f8fc !important;    
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3); 
        }

        /* 🎨 Style des boutons dans la navbar */
        .navbar-nav .nav-item .btn {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0.55rem 0.9rem;   
            font-weight: 600;
            border-radius: 0.375rem;  
        }

        /* 👋 Style du message de bienvenue */
        .user-greeting {
            color: #f1f8fc;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light text-dark">

<!-- 🚗 Barre de navigation principale -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- 🏠 Titre cliquable vers la page d'accueil -->
        <a href="/covoiturage/" class="navbar-brand navbar-brand-gros-titre">
            TOUCHE PAS AU KLAXON 🚗🔔
        </a>

        <!-- 📋 Menu de navigation à droite -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <div class="d-flex align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): ?>

                    <!-- 👤 Message de bienvenue personnalisé -->
                    <span class="user-greeting">
                        👋 Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                    </span>

                    <!-- ➕ Bouton pour créer un trajet (visible pour tous les utilisateurs connectés) -->
                    <a href="/covoiturage/trajet/create" class="btn btn-success btn-sm">Créer un trajet</a>

                    <!-- 🛠️ Bouton admin vers le tableau de bord -->
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/covoiturage/admin" class="btn btn-warning btn-sm text-dark">Tableau de bord</a>
                    <?php endif; ?>

                    <!-- 🚪 Bouton de déconnexion -->
                    <a href="/covoiturage/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>

                <?php else: ?>
                    <!-- 🔐 Bouton de connexion pour les visiteurs -->
                    <a href="/covoiturage/login" class="btn btn-light btn-sm">Connexion</a>
                <?php endif; ?>

            </div>
        </div>

        <!-- 📱 Bouton responsive pour afficher le menu sur mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

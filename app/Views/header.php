<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Covoiturage</title>

    <link href="/covoiturage/public/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Gros titre */
        .navbar-brand-gros-titre {
            font-size: 3.5rem;            
            font-weight: 900;             
            color: #f1f8fc !important;    
            text-shadow: 2px 2px 5px rgba(0,0,0,0.3); 
        }

        /* Boutons plus jolis et espacés */
        .navbar-nav .nav-item .btn {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding: 0.55rem 0.9rem;   
            font-weight: 600;
            border-radius: 0.375rem;  
        }

        /* Alignement "Bonjour" */
        .user-greeting {
            color: #f1f8fc;
            font-weight: 600;
        }
    </style>
</head>

<body class="bg-light text-dark">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm py-3">
    <div class="container d-flex justify-content-between align-items-center">

        <!-- Gros titre cliquable vers liste des trajets -->
        <a href="/covoiturage/" class="navbar-brand navbar-brand-gros-titre">
            TOUCHE PAS AU KLAXON 🚗🔔
        </a>

        <!-- Menu de droite -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <div class="d-flex align-items-center gap-3">

                <?php if (isset($_SESSION['user'])): ?>

                    <!-- Bonjour utilisateur -->
                    <span class="user-greeting">
                        👋 Bonjour <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                    </span>

                    <!-- Bouton créer un trajet visible pour tous les connectés -->
                    <a href="/covoiturage/trajet/create" class="btn btn-success btn-sm">Créer un trajet</a>

                    <!-- Admin : bouton tableau de bord -->
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/covoiturage/admin" class="btn btn-warning btn-sm text-dark">Tableau de bord</a>
                    <?php endif; ?>

                    <!-- Déconnexion -->
                    <a href="/covoiturage/logout" class="btn btn-outline-light btn-sm">Déconnexion</a>

                <?php else: ?>
                    <!-- Non connecté : bouton connexion -->
                    <a href="/covoiturage/login" class="btn btn-light btn-sm">Connexion</a>
                <?php endif; ?>

            </div>
        </div>

        <!-- Bouton responsive -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

    </div>
</nav>

-- ======================================================
-- Script d’alimentation de la base de données "covoiturage"
-- Objectif : insérer des données de test pour les agences, utilisateurs et trajets
-- ======================================================

-- 📌 Sélection de la base de données à utiliser
USE covoiturage;

-- ======================================================
-- 🏢 1️⃣ Insertion des agences
-- Chaque agence représente un point de départ ou d’arrivée pour les trajets
-- ======================================================
INSERT INTO agences (nom, ville, adresse) VALUES
('Agence Paris Centre', 'Paris', '10 Rue de Rivoli'), -- agence située à Paris
('Agence Lyon Part-Dieu', 'Lyon', '5 Rue de la République'), -- agence située à Lyon
('Agence Marseille Vieux-Port', 'Marseille', '2 Quai du Port'); -- agence située à Marseille

-- ======================================================
-- 👤 2️⃣ Insertion des utilisateurs
-- Les utilisateurs peuvent être des admins ou des passagers
-- ======================================================
-- ℹ️ Les mots de passe sont hashés avec bcrypt (exemple PHP)
-- Remplace les hash par ceux générés dynamiquement dans ton application
INSERT INTO users (nom, prenom, email, password, tel, role) VALUES
('Test', 'Admin', 'admin@test.com', '$2y$10$examplehashadmin', '0600000000', 'admin'), -- utilisateur admin
('Martin', 'Alexandre', 'alexandre.martin@email.fr', '$2y$10$examplehashuser1', '0612345678', 'user'), -- utilisateur classique
('Dubois', 'Sophie', 'sophie.dubois@email.fr', '$2y$10$examplehashuser2', '0698765432', 'user'); -- autre utilisateur classique

-- ======================================================
-- 🚗 3️⃣ Insertion des trajets
-- Chaque trajet est lié à un utilisateur et à deux agences (départ et arrivée)
-- ======================================================
INSERT INTO trajets (user_id, depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_dispo) VALUES
(2, 1, 2, '2025-11-15 08:00:00', '2025-11-15 12:00:00', 3, 3), -- trajet Paris → Lyon par Alexandre
(3, 2, 3, '2025-11-16 09:00:00', '2025-11-16 13:30:00', 4, 4), -- trajet Lyon → Marseille par Sophie
(2, 1, 3, '2025-11-17 07:30:00', '2025-11-17 12:00:00', 2, 2); -- trajet Paris → Marseille par Alexandre

-- ✅ Jeu d’essai prêt à l’emploi pour développement et tests

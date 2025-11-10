-- ======================================================
-- Script de création de la base de données Covoiturage
-- Auteur : [Ton Nom]
-- Date : [Date du jour]
-- ======================================================

-- 🔄 Suppression de l’ancienne base si elle existe
DROP DATABASE IF EXISTS covoiturage;

-- 🆕 Création de la base avec encodage UTF-8 multilingue
CREATE DATABASE covoiturage CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

-- 📌 Sélection de la base pour les opérations suivantes
USE covoiturage;

-- ======================================================
-- 🧑 Table : users
-- Stocke les informations des utilisateurs
-- ======================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identifiant unique
    nom VARCHAR(100) NOT NULL,         -- Nom de l'utilisateur
    prenom VARCHAR(100) NOT NULL,      -- Prénom de l'utilisateur
    email VARCHAR(150) NOT NULL UNIQUE,-- Email unique pour l'identification
    password VARCHAR(255) NOT NULL,    -- Mot de passe hashé
    tel VARCHAR(20) DEFAULT NULL,      -- Numéro de téléphone (optionnel)
    role ENUM('admin', 'user') DEFAULT 'user', -- Rôle de l'utilisateur
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Date de création
) ENGINE=InnoDB;

-- ======================================================
-- 🏢 Table : agences
-- Liste des agences de départ et d’arrivée
-- ======================================================
CREATE TABLE agences (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identifiant unique
    nom VARCHAR(150) NOT NULL,         -- Nom de l'agence
    ville VARCHAR(150) NOT NULL,       -- Ville où se trouve l'agence
    adresse VARCHAR(255) NOT NULL      -- Adresse complète
) ENGINE=InnoDB;

-- ======================================================
-- 🚗 Table : trajets
-- Contient les trajets proposés par les utilisateurs
-- ======================================================
CREATE TABLE trajets (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identifiant du trajet
    user_id INT NOT NULL,              -- Référence à l'utilisateur créateur
    depart_id INT NOT NULL,            -- Référence à l'agence de départ
    arrivee_id INT NOT NULL,           -- Référence à l'agence d’arrivée
    date_depart DATETIME NOT NULL,     -- Date et heure de départ
    date_arrivee DATETIME NOT NULL,    -- Date et heure d’arrivée
    places_total INT NOT NULL CHECK (places_total > 0), -- Nombre total de places
    places_dispo INT NOT NULL CHECK (places_dispo >= 0),-- Places restantes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,      -- Date de création

    -- 🔗 Clés étrangères
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_depart FOREIGN KEY (depart_id) REFERENCES agences(id) ON DELETE RESTRICT,
    CONSTRAINT fk_arrivee FOREIGN KEY (arrivee_id) REFERENCES agences(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ======================================================
-- ✅ Contraintes supplémentaires
-- Garanties de cohérence métier
-- ======================================================

-- ❌ Empêche que l’agence de départ soit identique à celle d’arrivée
ALTER TABLE trajets ADD CONSTRAINT chk_diff_agences CHECK (depart_id <> arrivee_id);

-- ⏱️ Empêche que la date d’arrivée soit antérieure ou égale à la date de départ
ALTER TABLE trajets ADD CONSTRAINT chk_dates_valide CHECK (date_arrivee > date_depart);

-- ======================================================
-- 🏁 Fin du script
-- La base "covoiturage" est prête à l’emploi !
-- ======================================================

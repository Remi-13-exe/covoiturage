USE covoiturage;

-- Utilisateurs (les passwords sont hashés)
INSERT INTO users (nom, prenom, telephone, email, password, role) VALUES
('Dupont', 'Jean', '0600000000', 'jean.dupont@mail.com', '$2y$10$exampleHashForJean1234567890abcdefghi', 'user'),
('Martin', 'Claire', '0611111111', 'claire.martin@mail.com', '$2y$10$exampleHashForClaire1234567890abcdef', 'admin');

-- Agences
INSERT INTO agences (nom) VALUES
('Paris'),
('Lyon'),
('Marseille'),
('Bordeaux');

-- Trajets
INSERT INTO trajets (user_id, depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_dispo) VALUES
(1, 1, 2, '2025-11-05 08:00:00', '2025-11-05 12:00:00', 4, 4),
(1, 2, 3, '2025-11-06 09:00:00', '2025-11-06 14:00:00', 3, 3);

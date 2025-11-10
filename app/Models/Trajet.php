<?php

/**
 * Modèle Trajet
 *
 * Gère les opérations CRUD liées aux trajets dans la base de données.
 */
class Trajet {
    /**
     * Instance PDO pour la connexion à la base de données.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur du modèle Trajet.
     *
     * @param PDO $pdo Instance PDO connectée à la base
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les trajets avec les informations liées (conducteur, agences).
     *
     * @return array Liste des trajets sous forme de tableau associatif
     */
    public function all() {
        $stmt = $this->pdo->query("
            SELECT 
                t.id,
                t.user_id,
                t.date_depart,
                t.date_arrivee,
                t.places_total,
                t.places_dispo,
                CONCAT(u.prenom, ' ', u.nom) AS conducteur,
                u.email,
                a1.nom AS depart,
                a2.nom AS arrivee
            FROM trajets t
            JOIN users u ON t.user_id = u.id
            JOIN agences a1 ON t.depart_id = a1.id
            JOIN agences a2 ON t.arrivee_id = a2.id
            ORDER BY t.date_depart ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un trajet spécifique par son identifiant.
     *
     * @param int $id Identifiant du trajet
     * @return array|null Détails du trajet ou null si non trouvé
     */
    public function find($id) {
        $stmt = $this->pdo->prepare("
            SELECT 
                t.id,
                t.user_id,
                t.depart_id,
                t.arrivee_id,
                t.date_depart,
                t.date_arrivee,
                t.places_total,
                t.places_dispo,
                CONCAT(u.prenom, ' ', u.nom) AS conducteur,
                u.email,
                a1.nom AS depart,
                a2.nom AS arrivee
            FROM trajets t
            JOIN users u ON t.user_id = u.id
            JOIN agences a1 ON t.depart_id = a1.id
            JOIN agences a2 ON t.arrivee_id = a2.id
            WHERE t.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau trajet dans la base de données.
     *
     * @param int $user_id ID de l'utilisateur créateur
     * @param int $depart_id ID de l'agence de départ
     * @param int $arrivee_id ID de l'agence d'arrivée
     * @param string $date_depart Date et heure de départ
     * @param string $date_arrivee Date et heure d'arrivée
     * @param int $places_total Nombre total de places disponibles
     * @return bool Succès ou échec de l'insertion
     */
    public function create($user_id, $depart_id, $arrivee_id, $date_depart, $date_arrivee, $places_total) {
        $stmt = $this->pdo->prepare("
            INSERT INTO trajets 
                (user_id, depart_id, arrivee_id, date_depart, date_arrivee, places_total, places_dispo)
            VALUES 
                (:user_id, :depart_id, :arrivee_id, :date_depart, :date_arrivee, :places_total, :places_total)
        ");
        return $stmt->execute([
            ':user_id' => $user_id,
            ':depart_id' => $depart_id,
            ':arrivee_id' => $arrivee_id,
            ':date_depart' => $date_depart,
            ':date_arrivee' => $date_arrivee,
            ':places_total' => $places_total
        ]);
    }

    /**
     * Met à jour les informations d’un trajet existant.
     *
     * @param int $id Identifiant du trajet
     * @param int $user_id ID de l'utilisateur créateur
     * @param int $depart_id ID de l'agence de départ
     * @param int $arrivee_id ID de l'agence d'arrivée
     * @param string $date_depart Date et heure de départ
     * @param string $date_arrivee Date et heure d'arrivée
     * @param int $places_total Nombre total de places
     * @return bool Succès ou échec de la mise à jour
     */
    public function update($id, $user_id, $depart_id, $arrivee_id, $date_depart, $date_arrivee, $places_total) {
        $stmt = $this->pdo->prepare("
            UPDATE trajets
            SET 
                user_id = :user_id,
                depart_id = :depart_id,
                arrivee_id = :arrivee_id,
                date_depart = :date_depart,
                date_arrivee = :date_arrivee,
                places_total = :places_total
            WHERE id = :id
        ");
        return $stmt->execute([
            ':user_id' => $user_id,
            ':depart_id' => $depart_id,
            ':arrivee_id' => $arrivee_id,
            ':date_depart' => $date_depart,
            ':date_arrivee' => $date_arrivee,
            ':places_total' => $places_total,
            ':id' => $id
        ]);
    }

    /**
     * Supprime un trajet de la base de données.
     *
     * @param int $id Identifiant du trajet à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM trajets WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

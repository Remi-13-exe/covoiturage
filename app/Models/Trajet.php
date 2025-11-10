<?php
class Trajet {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

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

    // 🔹 Création d’un trajet
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

    // 🔹 Mise à jour d’un trajet
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

    // 🔹 Suppression d’un trajet
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM trajets WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

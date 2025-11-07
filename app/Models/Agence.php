<?php
class Agence {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer toutes les agences
    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM agences");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Trouver une agence par son ID
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM agences WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

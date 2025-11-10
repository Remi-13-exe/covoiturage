<?php

/**
 * Modèle Agence
 *
 * Gère les opérations liées aux agences dans la base de données.
 */
class Agence {
    /**
     * Instance PDO pour la connexion à la base de données.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur du modèle Agence.
     *
     * @param PDO $pdo Instance PDO connectée à la base
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les agences enregistrées.
     *
     * @return array Liste des agences sous forme de tableau associatif
     */
    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM agences");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche une agence par son identifiant.
     *
     * @param int $id Identifiant de l'agence
     * @return array|null Données de l'agence ou null si non trouvée
     */
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM agences WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

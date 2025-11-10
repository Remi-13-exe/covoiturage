<?php

/**
 * Modèle User
 *
 * Gère les opérations liées aux utilisateurs dans la base de données.
 */
class User {
    /**
     * Instance PDO pour la connexion à la base de données.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur du modèle User.
     *
     * @param PDO $pdo Instance PDO connectée à la base
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère tous les utilisateurs enregistrés.
     *
     * @return array Liste des utilisateurs sous forme de tableau associatif
     */
    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recherche un utilisateur par son adresse email.
     *
     * @param string $email Adresse email de l'utilisateur
     * @return array|null Données de l'utilisateur ou null si non trouvé
     */
    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

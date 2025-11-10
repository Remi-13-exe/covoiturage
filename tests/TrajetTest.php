<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/Models/Trajet.php';

/**
 * Classe de test unitaire pour le modèle Trajet.
 *
 * Teste les opérations de création, suppression et gestion des erreurs liées aux trajets.
 *
 * @covers Trajet
 */
class TrajetTest extends TestCase
{
    /**
     * Instance PDO utilisée pour les tests.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * Instance du modèle Trajet.
     *
     * @var Trajet
     */
    private $trajetModel;

    /**
     * Prépare l'environnement de test avant chaque méthode.
     * Initialise la connexion PDO et le modèle Trajet.
     */
    protected function setUp(): void
    {
        $host = 'localhost';
        $db   = 'covoiturage';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $this->trajetModel = new Trajet($this->pdo);
    }

    /**
     * Teste la création d’un trajet valide.
     *
     * @return void
     */
    public function testCreateTrajet(): void
    {
        $result = $this->trajetModel->create(
            1, 1, 2, '2025-11-10 08:00:00', '2025-11-10 12:00:00', 4
        );
        $this->assertTrue($result);
    }

    /**
     * Teste la suppression d’un trajet après sa création.
     *
     * @return void
     */
    public function testDeleteTrajet(): void
    {
        // Crée un trajet temporaire
        $this->trajetModel->create(1, 1, 2, '2025-11-11 08:00:00', '2025-11-11 12:00:00', 3);

        // Récupère l’ID du dernier trajet créé
        $stmt = $this->pdo->query("SELECT id FROM trajets ORDER BY id DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();

        // Supprime le trajet et vérifie le succès
        $result = $this->trajetModel->delete($lastId);
        $this->assertTrue($result);
    }

    /**
     * Teste la création d’un trajet avec un ID utilisateur invalide.
     * Doit lever une exception PDO.
     *
     * @return void
     */
    public function testCreateTrajetInvalidUser(): void
    {
        $this->expectException(PDOException::class);

        $this->trajetModel->create(
            999, 1, 2, '2025-11-12 08:00:00', '2025-11-12 12:00:00', 2
        );
    }
}

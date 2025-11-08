<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../app/Models/Trajet.php';

class TrajetTest extends TestCase
{
    private $pdo;
    private $trajetModel;

    protected function setUp(): void
    {
        // Crée explicitement une connexion PDO pour les tests
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

    public function testCreateTrajet()
    {
        $result = $this->trajetModel->create(
            1, 1, 2, '2025-11-10 08:00:00', '2025-11-10 12:00:00', 4
        );
        $this->assertTrue($result);
    }

    public function testDeleteTrajet()
    {
        // Crée un trajet temporaire
        $this->trajetModel->create(1, 1, 2, '2025-11-11 08:00:00', '2025-11-11 12:00:00', 3);

        $stmt = $this->pdo->query("SELECT id FROM trajets ORDER BY id DESC LIMIT 1");
        $lastId = $stmt->fetchColumn();

        $result = $this->trajetModel->delete($lastId);
        $this->assertTrue($result);
    }

    public function testCreateTrajetInvalidUser()
    {
        $this->expectException(PDOException::class);

        $this->trajetModel->create(
            999, 1, 2, '2025-11-12 08:00:00', '2025-11-12 12:00:00', 2
        );
    }
}

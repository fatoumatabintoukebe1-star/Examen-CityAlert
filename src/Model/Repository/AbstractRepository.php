<?php
namespace App\Model\Repository;
use App\Interfaces\RepositoryInterface;
use App\Core\Database;
abstract class AbstractRepository implements RepositoryInterface {
protected \PDO $pdo;
public function __construct() {
$this->pdo = Database::getInstance();
}
// Méthode utilitaire pour les requêtes préparées
protected function query(string $sql, array $params = []): \PDOStatement {
$stmt = $this->pdo->prepare($sql);
$stmt->execute($params);
return $stmt;
}
}
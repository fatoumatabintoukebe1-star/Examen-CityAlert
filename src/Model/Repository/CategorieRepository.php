<?php
namespace App\Model\Repository;
use App\Model\Entity\Categorie\{
Categorie, CategorieVoirie, CategorieEclairage,
CategorieDechets, CategorieEau
};
use App\Exception\EntityNotFoundException;
class CategorieRepository extends AbstractRepository {
private function hydrate(array $row): Categorie {
$cat = match($row['type']) {
'voirie' => new CategorieVoirie(),
'eclairage' => new CategorieEclairage(),
'dechets' => new CategorieDechets(),
'eau' => new CategorieEau(),
};
$cat->setId($row['id']);
$cat->setNom($row['nom']);
$cat->setDescription($row['description'] ?? '');
return $cat;
}
public function findById(int $id): ?object {
$row = $this->query(
'SELECT * FROM categories WHERE id = ?', [$id]
)->fetch();
if (!$row) throw new EntityNotFoundException('Categorie', $id);
return $this->hydrate($row);
}
public function findAll(): array {
$rows = $this->query('SELECT * FROM categories')->fetchAll();
return array_map(fn($r) => $this->hydrate($r), $rows);
}
// Méthodes requises par RepositoryInterface (non utilisées ici)
public function save(object $entity): void {}
public function delete(int $id): void {}
}

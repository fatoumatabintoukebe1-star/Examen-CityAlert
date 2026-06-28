<?php
namespace App\Model\Repository;
use App\Model\Entity\Signalement;
use App\Exception\EntityNotFoundException;
class SignalementRepository extends AbstractRepository {
private function hydrate(array $row): Signalement {
$s = new Signalement(
$row['titre'], $row['description'],
$row['adresse'], $row['citoyen_id'], $row['categorie_id']
);
$s->setId($row['id']);
$s->setStatut($row['statut']);
$s->setPhoto($row['photo'] ?? null);
$s->setCreatedAt(new \DateTime($row['created_at']));
$s->setUpdatedAt(new \DateTime($row['updated_at']));
$s->setLatitude(isset($row['latitude']) ? (float)$row['latitude'] : null);
$s->setLongitude(isset($row['longitude']) ? (float)$row['longitude'] : null);
return $s;
}
public function findById(int $id): ?object {
$row = $this->query('SELECT * FROM signalements WHERE id = ?', [$id])->fetch();
if (!$row) throw new EntityNotFoundException('Signalement', $id);
return $this->hydrate($row);
}
public function findAll(): array {
$rows = $this->query(
'SELECT * FROM signalements ORDER BY created_at DESC'
)->fetchAll();
return array_map(fn($r) => $this->hydrate($r), $rows);
}
public function findByFilters(array $filters = [], int $page = 1,
int $perPage = 10): array {
$sql = 'SELECT * FROM signalements WHERE 1=1';
$params = [];
if (!empty($filters['statut'])) {
$sql .= ' AND statut = ?'; $params[] = $filters['statut'];
}
if (!empty($filters['categorie_id'])) {
$sql .= ' AND categorie_id = ?'; $params[] = $filters['categorie_id'];
}
if (!empty($filters['citoyen_id'])) {
$sql .= ' AND citoyen_id = ?'; $params[] = $filters['citoyen_id'];
}
// Compter le total pour la pagination
$count = $this->query(
str_replace('SELECT *', 'SELECT COUNT(*) as total', $sql), $params
)->fetch()['total'];
$offset = ($page - 1) * $perPage;
$sql .= ' ORDER BY created_at DESC LIMIT ? OFFSET ?';
$params[] = $perPage; $params[] = $offset;
$rows = $this->query($sql, $params)->fetchAll();
return ['data' => array_map(fn($r) => $this->hydrate($r), $rows),
'total' => $count, 'pages' => ceil($count / $perPage),
'current_page' => $page];
}
public function save(object $entity): void {
if ($entity->getId() === null) {
$this->query(
'INSERT INTO signalements
(titre,description,adresse,photo,statut,priorite,citoyen_id,categorie_id)
VALUES (?,?,?,?,?,?,?,?)',
[$entity->getTitre(), $entity->getDescription(),
$entity->getAdresse(), $entity->getPhoto(),
$entity->getStatut(), $entity->getPriorite(),
$entity->getCitoyenId(), $entity->getCategorieId()]
);
} else {
$this->query(
'UPDATE signalements
SET titre=?,description=?,adresse=?,statut=?,priorite=?,
updated_at=NOW()
WHERE id=?',
[$entity->getTitre(), $entity->getDescription(),
$entity->getAdresse(), $entity->getStatut(),
$entity->getPriorite(), $entity->getId()]
);
}
}
public function delete(int $id): void {
$this->query('DELETE FROM signalements WHERE id = ?', [$id]);
}
public function getStatistiques(): array {
$stats = $this->query(
'SELECT statut, COUNT(*) as nb FROM signalements GROUP BY statut'
)->fetchAll();
$cat = $this->query(
'SELECT c.nom, COUNT(s.id) as nb
FROM signalements s JOIN categories c ON s.categorie_id=c.id
GROUP BY c.nom'
)->fetchAll();
return ['par_statut' => $stats, 'par_categorie' => $cat];
}
}
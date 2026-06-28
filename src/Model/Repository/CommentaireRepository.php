<?php
namespace App\Model\Repository;
use App\Model\Entity\Commentaire;
class CommentaireRepository extends AbstractRepository {
public function findBySignalement(int $signalementId): array {
$rows = $this->query(
'SELECT c.*, u.nom, u.prenom, u.role
FROM commentaires c
JOIN users u ON c.auteur_id = u.id
WHERE c.signalement_id = ?
ORDER BY c.created_at ASC',
[$signalementId]
)->fetchAll();
return array_map(function($row) {
$c = new Commentaire($row['contenu'], $row['auteur_id'],
$row['signalement_id']);
$c->setId($row['id']);
$c->setAuteurNom($row['prenom'] . ' ' . $row['nom']);
$c->setAuteurRole($row['role']);
$c->setCreatedAt(new \DateTime($row['created_at']));
return $c;
}, $rows);
}
public function findById(int $id): ?object { return null; }
public function findAll(): array { return []; }
public function save(object $entity): void {
$this->query(
'INSERT INTO commentaires (contenu, auteur_id, signalement_id)
VALUES (?, ?, ?)',
[$entity->getContenu(), $entity->getAuteurId(),
$entity->getSignalementId()]
);
}
public function delete(int $id): void {
$this->query('DELETE FROM commentaires WHERE id = ?', [$id]);
}
}
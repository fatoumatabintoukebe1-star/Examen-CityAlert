<?php
namespace App\Model\Repository;
use App\Model\Entity\HistoriqueStatut;
class HistoriqueRepository extends AbstractRepository {
public function findById(int $id): ?object { return null; }
public function findAll(): array { return []; }
public function delete(int $id): void {}
public function findBySignalement(int $signalementId): array {
return $this->query(
'SELECT h.*, u.nom, u.prenom
FROM historique_statuts h
JOIN users u ON h.agent_id = u.id
WHERE h.signalement_id = ?
ORDER BY h.date_changement DESC',
[$signalementId]
)->fetchAll();
}
public function save(object $entity): void {
$this->query(
'INSERT INTO historique_statuts
(signalement_id,agent_id,ancien_statut,nouveau_statut,commentaire)
VALUES (?,?,?,?,?)',
[$entity->getSignalementId(), $entity->getAgentId(),
$entity->getAncienStatut(), $entity->getNouveauStatut(),
$entity->getCommentaire()]
);
}
}

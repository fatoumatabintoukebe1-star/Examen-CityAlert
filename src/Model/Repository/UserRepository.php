<?php
namespace App\Model\Repository;
use App\Model\Entity\{User, Citoyen, AgentMunicipal, Administrateur};
use App\Exception\EntityNotFoundException;
class UserRepository extends AbstractRepository {
private function hydrate(array $row): User {
$user = match($row['role']) {
'agent' => new AgentMunicipal($row['nom'],$row['prenom'],$row['email']),
'administrateur' => new Administrateur($row['nom'],$row['prenom'],$row['email']),
default => new Citoyen($row['nom'], $row['prenom'], $row['email']),
};
$user->setId($row['id']);
$user->setActif((int)($row['actif'] ?? 1));
$user->setMotDePasseHash($row['mot_de_passe']);
if ($user instanceof Citoyen) {
$user->setAdresse($row['adresse'] ?? '');
$user->setTelephone($row['telephone'] ?? '');
}
if ($user instanceof AgentMunicipal) {
$user->setMatricule($row['matricule'] ?? '');
$user->setCategorieAgent($row['categorie'] ?? '');
}
return $user;
}
public function findById(int $id): ?object {
$row = $this->query('SELECT * FROM users WHERE id = ?', [$id])->fetch();
if (!$row) throw new EntityNotFoundException('User', $id);
return $this->hydrate($row);
}
public function findAll(): array {
return array_map(fn($r) => $this->hydrate($r),
$this->query('SELECT * FROM users ORDER BY created_at DESC')->fetchAll());
}
public function findByEmail(string $email): ?User {
$row = $this->query('SELECT * FROM users WHERE email = ?', [$email])->fetch();
return $row ? $this->hydrate($row) : null;
}
public function save(object $entity): void {
if ($entity->getId() === null) {
$this->query(
'INSERT INTO users (nom,prenom,email,mot_de_passe,role,adresse,telephone)
VALUES (?,?,?,?,?,?,?)',
[$entity->getNom(), $entity->getPrenom(), $entity->getEmail(),
$entity->getMotDePasse(), $entity->getRole(),
($entity instanceof Citoyen ? $entity->getAdresse() : ''),
($entity instanceof Citoyen ? $entity->getTelephone() : '')]
);
}
}
public function delete(int $id): void {
$this->query('DELETE FROM users WHERE id = ?', [$id]);
}
public function toggleActif(int $id, int $actif): void {
    $this->query(
        'UPDATE users SET actif = ? WHERE id = ?',
        [$actif, $id]
    );
}

public function updateRole(int $id, string $role): void {
    $this->query(
        'UPDATE users SET role = ? WHERE id = ?',
        [$role, $id]
    );
}
}
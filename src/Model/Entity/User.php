<?php
namespace App\Model\Entity;
use App\Interfaces\NotifiableInterface;
use App\Traits\Timestampable;
abstract class User implements NotifiableInterface {
use Timestampable;
protected ?int $id = null;
protected string $nom;
protected string $prenom;
protected string $email;
protected string $motDePasse;
protected string $role;
protected bool $actif = true;
public function __construct(string $nom, string $prenom,
string $email, string $role) {
$this->nom = $nom;
$this->prenom = $prenom;
$this->email = $email;
$this->role = $role;
}
// Getters
public function getId(): ?int { return $this->id; }
public function getNom(): string { return $this->nom; }
public function getPrenom(): string{ return $this->prenom; }
public function getEmail(): string { return $this->email; }
public function getRole(): string { return $this->role; }
public function isActif(): bool { return $this->actif === true; }
public function setActif(int $actif): void {
    $this->actif = $actif === 1;
}
public function getNomComplet(): string {
return $this->prenom . ' ' . $this->nom;
}
// Setters
public function setId(int $id): void { $this->id = $id; }
public function setMotDePasse(string $mdp): void {
$this->motDePasse = password_hash($mdp, PASSWORD_DEFAULT);
}
public function setMotDePasseHash(string $hash): void {
$this->motDePasse = $hash;
}
public function verifierMotDePasse(string $mdp): bool {
return password_verify($mdp, $this->motDePasse);
}
public function getMotDePasse(): string { return $this->motDePasse; }
// NotifiableInterface
public function notify(string $message): void {
// Pour l'instant : log console. Bonus : envoyer un email
error_log('[CityAlert] Notification pour ' . $this->email . ': ' . $message);
}
// Méthode abstraite — chaque rôle définit ses permissions
abstract public function getPermissions(): array;
}


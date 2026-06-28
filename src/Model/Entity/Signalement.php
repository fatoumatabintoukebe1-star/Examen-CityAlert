<?php
namespace App\Model\Entity;
use App\Traits\Timestampable;
use App\Model\Entity\Categorie\Categorie;
class Signalement {
use Timestampable;
private ?int $id = null;
private string $titre;
private string $description;
private string $adresse;
private ?string $photo = null;
private string $statut = 'Nouveau';
private string $priorite = 'moyenne';
private ?Citoyen $citoyen = null;
private ?Categorie $categorie = null;
private int $citoyenId;
private int $categorieId;
public function __construct(string $titre, string $description,
string $adresse, int $citoyenId,
int $categorieId) {
$this->titre = $titre;
$this->description = $description;
$this->adresse = $adresse;
$this->citoyenId = $citoyenId;
$this->categorieId = $categorieId;
$this->setCreatedAt(new \DateTime());
$this->setUpdatedAt(new \DateTime());
}
// Getters
public function getId(): ?int { return $this->id; }
public function getTitre(): string { return $this->titre; }
public function getDescription(): string { return $this->description; }
public function getAdresse(): string { return $this->adresse; }
public function getPhoto(): ?string { return $this->photo; }
public function getStatut(): string { return $this->statut; }
public function getPriorite(): string { return $this->priorite; }
public function getCitoyenId(): int { return $this->citoyenId; }
public function getCategorieId(): int { return $this->categorieId; }
public function getCitoyen(): ?Citoyen { return $this->citoyen; }
public function getCategorie(): ?Categorie { return $this->categorie; }
// Setters
public function setId(int $id): void { $this->id = $id; }
public function setPhoto(?string $p): void { $this->photo = $p; }
public function setStatut(string $s): void { $this->statut = $s; }
public function setPriorite(string $p): void { $this->priorite = $p; }
public function setCitoyen(Citoyen $c): void { $this->citoyen = $c; }
public function setCategorie(Categorie $c): void { $this->categorie = $c; }
public function estModifiable(): bool {
return $this->statut === 'Nouveau';
}
public function getStatutBadgeClass(): string {
return match($this->statut) {
'Nouveau' => 'badge-nouveau',
'EnCours' => 'badge-encours',
'Resolu' => 'badge-resolu',
'Rejete' => 'badge-rejete',
default => 'badge-default',
};
}
private ?float $latitude  = null;
private ?float $longitude = null;

public function getLatitude(): ?float  { return $this->latitude; }
public function getLongitude(): ?float { return $this->longitude; }
public function setLatitude(?float $l): void  { $this->latitude = $l; }
public function setLongitude(?float $l): void { $this->longitude = $l; }
}
<?php
namespace App\Model\Entity\Categorie;
abstract class Categorie {
protected ?int $id = null;
protected string $nom = '';
protected string $description = '';
protected string $type = '';
public function getId(): ?int { return $this->id; }
public function getNom(): string { return $this->nom; }
public function getDescription(): string { return $this->description; }
public function getType(): string { return $this->type; }
public function setId(int $id): void { $this->id = $id; }
public function setNom(string $n): void { $this->nom = $n; }
public function setDescription(string $d): void { $this->description = $d; }
// Méthodes abstraites — polymorphisme obligatoire
abstract public function getDelaiTraitement(): int; // en jours
abstract public function getPrioriteDefaut(): string;
abstract public function getIcone(): string;
}
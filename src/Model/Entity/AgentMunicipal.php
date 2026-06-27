<?php // AgentMunicipal.php
namespace App\Model\Entity;
class AgentMunicipal extends User {
private string $matricule = '';
private string $categorieAgent = '';
public function __construct(string $nom, string $prenom, string $email) {
parent::__construct($nom, $prenom, $email, 'agent');
}
public function getMatricule(): string { return $this->matricule; }
public function getCategorieAgent(): string { return $this->categorieAgent; }
public function setMatricule(string $m): void { $this->matricule = $m; }
public function setCategorieAgent(string $c): void { $this->categorieAgent = $c; }
public function getPermissions(): array {
return ['voir_signalements','changer_statut','ajouter_remarque','commenter'];
}
}
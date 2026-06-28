<?php
namespace App\Model\Entity;
class Citoyen extends User {
private string $adresse = '';
private string $telephone = '';
public function __construct(string $nom, string $prenom, string $email) {
parent::__construct($nom, $prenom, $email, 'citoyen');
}
public function getAdresse(): string { return $this->adresse; }
public function getTelephone(): string { return $this->telephone; }
public function setAdresse(string $a): void { $this->adresse = $a; }
public function setTelephone(string $t): void { $this->telephone = $t; }
public function getPermissions(): array {
return ['creer_signalement','voir_ses_signalements',
'modifier_ses_signalements','commenter'];
}
}
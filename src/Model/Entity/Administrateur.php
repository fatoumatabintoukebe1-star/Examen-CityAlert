<?php // Administrateur.php
namespace App\Model\Entity;
class Administrateur extends User {
public function __construct(string $nom, string $prenom, string $email) {
parent::__construct($nom, $prenom, $email, 'administrateur');
}
public function getPermissions(): array {
return ['tout'];
}
}
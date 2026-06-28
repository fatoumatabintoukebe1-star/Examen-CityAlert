<?php // CategorieEclairage.php
namespace App\Model\Entity\Categorie;
class CategorieEclairage extends Categorie {
protected string $type = 'eclairage';
public function getDelaiTraitement(): int { return 3; }
public function getPrioriteDefaut(): string { return 'moyenne'; }
public function getIcone(): string { return 'lightbulb'; }
}
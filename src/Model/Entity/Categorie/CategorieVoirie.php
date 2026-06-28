<?php // CategorieVoirie.php
namespace App\Model\Entity\Categorie;

class CategorieVoirie extends Categorie {
protected string $type = 'voirie';
public function getDelaiTraitement(): int { return 7; }
public function getPrioriteDefaut(): string { return 'haute'; }
public function getIcone(): string { return 'road'; }
}
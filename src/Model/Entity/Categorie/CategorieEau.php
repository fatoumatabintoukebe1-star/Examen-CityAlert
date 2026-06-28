<?php // CategorieEau.php
namespace App\Model\Entity\Categorie;
class CategorieEau extends Categorie {
protected string $type = 'eau';
public function getDelaiTraitement(): int { return 1; }
public function getPrioriteDefaut(): string { return 'urgente'; }
public function getIcone(): string { return 'water'; }
}
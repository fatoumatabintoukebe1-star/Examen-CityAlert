<?php // CategorieDechets.php
namespace App\Model\Entity\Categorie;
class CategorieDechets extends Categorie {
protected string $type = 'dechets';
public function getDelaiTraitement(): int { return 2; }
public function getPrioriteDefaut(): string { return 'basse'; }
public function getIcone(): string { return 'trash'; }
}
<?php // EntityNotFoundException.php
namespace App\Exception;
class EntityNotFoundException extends AppException {
public function __construct(string $entity, int $id) {
parent::__construct("$entity avec l'id $id introuvable.");
}
}
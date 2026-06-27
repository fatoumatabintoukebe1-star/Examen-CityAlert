<?php // ValidationException.php
namespace App\Exception;
class ValidationException extends AppException {
private array $errors;
public function __construct(array $errors) {
parent::__construct('Erreur de validation.');
$this->errors = $errors;
}
public function getErrors(): array { return $this->errors; }
}
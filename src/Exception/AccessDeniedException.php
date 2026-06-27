<?php // AccessDeniedException.php
namespace App\Exception;
class AccessDeniedException extends AppException {
public function __construct() {
parent::__construct('Accès refusé. Vous n\'avez pas les droits.');
}
}
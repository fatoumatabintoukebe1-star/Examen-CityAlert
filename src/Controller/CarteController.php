<?php
namespace App\Controller;
use App\Model\Repository\SignalementRepository;

class CarteController {
    public function index(): void {
        $repo         = new SignalementRepository();
        $signalements = $repo->findAll();
        require __DIR__ . '/../../views/carte.php';
    }
}
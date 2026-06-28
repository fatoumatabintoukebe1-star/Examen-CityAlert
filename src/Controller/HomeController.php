<?php
namespace App\Controller;
use App\Core\Auth;

class HomeController {
   public function index(): void {
       if (Auth::isLoggedIn()) {
           $redirect = match(Auth::role()) {
               'administrateur' => BASE_URL . '/admin/dashboard',
               'agent'          => BASE_URL . '/agent/dashboard',
               default          => BASE_URL . '/signalements',
           };
           header('Location: ' . $redirect); exit;
       }
       require __DIR__ . '/../../views/home.php';
   }
}
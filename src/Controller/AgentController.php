<?php
namespace App\Controller;
use App\Model\Repository\{SignalementRepository, HistoriqueRepository};
use App\Model\Entity\HistoriqueStatut;
use App\Core\{Session, Auth};

class AgentController {
   private SignalementRepository $repo;
   private HistoriqueRepository  $histoRepo;

   public function __construct() {
       $this->repo      = new SignalementRepository();
       $this->histoRepo = new HistoriqueRepository();
   }

   public function dashboard(): void {
       $signalements = $this->repo->findByFilters([], 1, 20)['data'];
       require __DIR__ . '/../../views/agent/dashboard.php';
   }

   public function updateStatut(string $id): void {
       $signalement  = $this->repo->findById((int)$id);
       $ancienStatut = $signalement->getStatut();
       $nouveauStatut= $_POST['statut'] ?? '';
       $commentaire  = trim($_POST['commentaire'] ?? '');

       $statutsValides = ['EnCours', 'Resolu', 'Rejete'];
       if (!in_array($nouveauStatut, $statutsValides)) {
           Session::flash('error', 'Statut invalide.');
           header('Location: ' . BASE_URL . '/agent/dashboard'); exit;
       }

       $signalement->setStatut($nouveauStatut);
       $this->repo->save($signalement);

       $historique = new HistoriqueStatut(
           (int)$id, Auth::user()['id'],
           $ancienStatut, $nouveauStatut, $commentaire
       );
       $this->histoRepo->save($historique);
       // Envoyer email au citoyen
try {
    $userRepo = new \App\Model\Repository\UserRepository();
    $citoyen  = $userRepo->findById($signalement->getCitoyenId());
    
    $emailService = new \App\Services\EmailService();
    $emailService->envoyerChangementStatut(
        $citoyen->getEmail(),
        $citoyen->getNomComplet(),
        $signalement->getTitre(),
        $ancienStatut,
        $nouveauStatut,
        $commentaire
    );
} catch (\Exception $e) {
    error_log('Erreur email: ' . $e->getMessage());
}

       Session::flash('success', 'Statut mis à jour.');
       header('Location: ' . BASE_URL . '/signalements/' . $id); exit;
   }
}
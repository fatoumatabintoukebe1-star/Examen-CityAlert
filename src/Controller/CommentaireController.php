<?php
namespace App\Controller;
use App\Model\Repository\CommentaireRepository;
use App\Model\Entity\Commentaire;
use App\Core\{Auth, Session};

class CommentaireController {
   public function store(string $id): void {
       $contenu = trim($_POST['contenu'] ?? '');

       if (!$contenu) {
           Session::flash('error', 'Le commentaire ne peut pas être vide.');
           header('Location: ' . BASE_URL . '/signalements/' . $id); exit;
       }

       $commentaire = new Commentaire($contenu, Auth::user()['id'], (int)$id);
       (new CommentaireRepository())->save($commentaire);
       header('Location: ' . BASE_URL . '/signalements/' . $id . '#commentaires'); exit;
   }
}

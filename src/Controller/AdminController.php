<?php
namespace App\Controller;
use App\Model\Repository\{SignalementRepository, UserRepository, CategorieRepository};

class AdminController {

    public function dashboard(): void {
        $repo  = new SignalementRepository();
        $stats = $repo->getStatistiques();
        $total = array_sum(array_column($stats['par_statut'], 'nb'));
        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function users(): void {
        $users   = (new UserRepository())->findAll();
        $success = \App\Core\Session::getFlash('success');
        $error   = \App\Core\Session::getFlash('error');
        require __DIR__ . '/../../views/admin/users.php';
    }

public function toggleActif(string $id): void {
    $repo = new UserRepository();
    $user = $repo->findById((int)$id);
    $nouvelEtat = $user->isActif() ? 0 : 1;
    $repo->toggleActif((int)$id, $nouvelEtat);
    \App\Core\Session::flash('success', 'Statut mis à jour !');
    header('Location: ' . BASE_URL . '/admin/users'); exit;
}

    public function changeRole(string $id): void {
        $role = $_POST['role'] ?? '';
        $rolesValides = ['citoyen', 'agent', 'administrateur'];
        if (!in_array($role, $rolesValides)) {
            \App\Core\Session::flash('error', 'Rôle invalide.');
            header('Location: ' . BASE_URL . '/admin/users'); exit;
        }
        (new UserRepository())->updateRole((int)$id, $role);
        \App\Core\Session::flash('success', 'Rôle mis à jour.');
        header('Location: ' . BASE_URL . '/admin/users'); exit;
    }

    public function deleteUser(string $id): void {
        (new UserRepository())->delete((int)$id);
        \App\Core\Session::flash('success', 'Utilisateur supprimé.');
        header('Location: ' . BASE_URL . '/admin/users'); exit;
    }

    public function categories(): void {
        $categories = (new CategorieRepository())->findAll();
        $success    = \App\Core\Session::getFlash('success');
        require __DIR__ . '/../../views/admin/categories.php';
    }

    public function exportCsv(): void {
        $signalements = (new SignalementRepository())->findAll();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="signalements_' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
        fputcsv($out, ['ID','Titre','Adresse','Statut','Priorité','Date'], ';');
        foreach ($signalements as $s) {
            fputcsv($out, [
                $s->getId(),
                $s->getTitre(),
                $s->getAdresse(),
                $s->getStatut(),
                $s->getPriorite(),
                $s->getCreatedAt()->format('d/m/Y'),
            ], ';');
        }
        fclose($out); exit;
    }
}
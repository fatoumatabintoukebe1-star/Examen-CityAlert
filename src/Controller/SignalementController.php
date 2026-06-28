<?php
namespace App\Controller;
use App\Model\Repository\{SignalementRepository, CategorieRepository, CommentaireRepository};
use App\Model\Entity\Signalement;
use App\Core\{Session, Auth};
use App\Exception\{EntityNotFoundException, AccessDeniedException};

class SignalementController {
    private SignalementRepository $repo;
    private CategorieRepository   $catRepo;

    public function __construct() {
        $this->repo    = new SignalementRepository();
        $this->catRepo = new CategorieRepository();
    }

    public function index(): void {
        $filters = [];
        if (!empty($_GET['statut']))       $filters['statut']       = $_GET['statut'];
        if (!empty($_GET['categorie_id'])) $filters['categorie_id'] = (int)$_GET['categorie_id'];
        if (Auth::check('citoyen'))        $filters['citoyen_id']   = Auth::user()['id'];

        $page       = max(1, (int)($_GET['page'] ?? 1));
        $result     = $this->repo->findByFilters($filters, $page, 10);
        $categories = $this->catRepo->findAll();
        require __DIR__ . '/../../views/signalement/index.php';
    }

    public function create(): void {
        $categories = $this->catRepo->findAll();
        $error      = Session::getFlash('error');
        require __DIR__ . '/../../views/signalement/create.php';
    }

    public function store(): void {
        $titre       = trim($_POST['titre']       ?? '');
        $description = trim($_POST['description'] ?? '');
        $adresse     = trim($_POST['adresse']     ?? '');
        $categorieId = (int)($_POST['categorie_id'] ?? 0);

        if (!$titre || !$description || !$adresse || !$categorieId) {
            Session::flash('error', 'Tous les champs obligatoires doivent être remplis.');
            header('Location: ' . BASE_URL . '/signalements/create'); exit;
        }

        $s = new Signalement($titre, $description, $adresse,
                             Auth::user()['id'], $categorieId);
        $cat = $this->catRepo->findById($categorieId);
        $s->setPriorite($cat->getPrioriteDefaut());
        $this->repo->save($s);

        Session::flash('success', 'Signalement créé avec succès !');
        header('Location: ' . BASE_URL . '/signalements'); exit;
    }

    public function show(string $id): void {
        $signalement  = $this->repo->findById((int)$id);
        $commentaires = (new CommentaireRepository())->findBySignalement((int)$id);
        $historique   = (new \App\Model\Repository\HistoriqueRepository())
                            ->findBySignalement((int)$id);
        $error   = Session::getFlash('error');
        $success = Session::getFlash('success');
        require __DIR__ . '/../../views/signalement/show.php';
    }

    public function edit(string $id): void {
        $signalement = $this->repo->findById((int)$id);
        if (!$signalement->estModifiable() ||
            $signalement->getCitoyenId() !== Auth::user()['id']) {
            throw new AccessDeniedException();
        }
        $categories = $this->catRepo->findAll();
        require __DIR__ . '/../../views/signalement/edit.php';
    }

    public function update(string $id): void {
        $signalement = $this->repo->findById((int)$id);
        if (!$signalement->estModifiable() ||
            $signalement->getCitoyenId() !== Auth::user()['id']) {
            throw new AccessDeniedException();
        }
        $signalement->setStatut('Nouveau');
        $this->repo->save($signalement);
        header('Location: ' . BASE_URL . '/signalements/' . $id); exit;
    }

    public function delete(string $id): void {
        $signalement = $this->repo->findById((int)$id);
        if (!$signalement->estModifiable() ||
            $signalement->getCitoyenId() !== Auth::user()['id']) {
            throw new AccessDeniedException();
        }
        $this->repo->delete((int)$id);
        Session::flash('success', 'Signalement supprimé.');
        header('Location: ' . BASE_URL . '/signalements'); exit;
    }
}
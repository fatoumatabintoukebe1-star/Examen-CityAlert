<?php
namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Model\Entity\Citoyen;
use App\Core\{Session, Auth};

class AuthController {
    private UserRepository $repo;

    public function __construct() {
        $this->repo = new UserRepository();
    }

    public function showLogin(): void {
        $error = Session::getFlash('error');
        require __DIR__ . '/../../views/auth/login.php';
    }

    public function login(): void {
        $email = trim($_POST['email'] ?? '');
        $mdp   = $_POST['mot_de_passe'] ?? '';

        if (!$email || !$mdp) {
            Session::flash('error', 'Veuillez remplir tous les champs.');
            header('Location: ' . BASE_URL . '/login'); exit;
        }

        $user = $this->repo->findByEmail($email);

        if (!$user || !$user->verifierMotDePasse($mdp)) {
            Session::flash('error', 'Email ou mot de passe incorrect.');
            header('Location: ' . BASE_URL . '/login'); exit;
        }
        // Vérifier si le compte est actif
if (!$user->isActif()) {
    Session::flash('error', 'Votre compte a été désactivé.');
    header('Location: ' . BASE_URL . '/login'); exit;
}

        Session::set('user', [
            'id'    => $user->getId(),
            'nom'   => $user->getNomComplet(),
            'email' => $user->getEmail(),
            'role'  => $user->getRole(),
        ]);

        $redirect = match($user->getRole()) {
            'agent'          => BASE_URL . '/agent/dashboard',
            'administrateur' => BASE_URL . '/admin/dashboard',
            default          => BASE_URL . '/signalements',
        };
        header('Location: ' . $redirect); exit;
    }

    public function showRegister(): void {
        $error = Session::getFlash('error');
        require __DIR__ . '/../../views/auth/register.php';
    }

    public function register(): void {
        $nom     = trim($_POST['nom']    ?? '');
        $prenom  = trim($_POST['prenom'] ?? '');
        $email   = trim($_POST['email']  ?? '');
        $mdp     = $_POST['mot_de_passe'] ?? '';
        $confirm = $_POST['confirmation'] ?? '';

        $errors = [];
        if (!$nom)    $errors[] = 'Le nom est requis.';
        if (!$prenom) $errors[] = 'Le prenom est requis.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email invalide.';
        if (strlen($mdp) < 8)  $errors[] = 'Mot de passe : 8 caracteres minimum.';
        if ($mdp !== $confirm) $errors[] = 'Les mots de passe ne correspondent pas.';
        if ($this->repo->findByEmail($email)) $errors[] = 'Email deja utilise.';

        if ($errors) {
            Session::flash('error', implode('<br>', $errors));
            header('Location: ' . BASE_URL . '/register'); exit;
        }

        $citoyen = new Citoyen($nom, $prenom, $email);
        $citoyen->setMotDePasse($mdp);
        $this->repo->save($citoyen);

        Session::flash('success', 'Compte cree ! Vous pouvez vous connecter.');
        header('Location: ' . BASE_URL . '/login'); exit;
    }

    public function logout(): void {
        Session::destroy();
        header('Location: ' . BASE_URL . '/login'); exit;
    }
}

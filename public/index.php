<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

// BASE_URL pour les redirections PHP
define('BASE_URL', '/essaie/public');
// ASSETS_URL pour les liens CSS/JS dans les vues HTML
define('ASSETS_URL', '/essaie/public');

$_ENV['DB_HOST']     = 'localhost';
$_ENV['DB_NAME']     = 'cityalert';
$_ENV['DB_USER']     = 'root';
$_ENV['DB_PASSWORD'] = '';

use App\Core\{Router, Session};
use App\Controller\{HomeController, AuthController,
    SignalementController, CommentaireController,
    AdminController, AgentController};

Session::start();
$router = new Router();

// Routes publiques
$router->add('GET',  '/',          HomeController::class, 'index');
$router->add('GET',  '/login',     AuthController::class, 'showLogin');
$router->add('POST', '/login',     AuthController::class, 'login');
$router->add('GET',  '/register',  AuthController::class, 'showRegister');
$router->add('POST', '/register',  AuthController::class, 'register');
$router->add('GET',  '/logout',    AuthController::class, 'logout');

// Routes citoyen
$router->add('GET',  '/signalements',             SignalementController::class, 'index',  ['citoyen','agent','administrateur']);
$router->add('GET',  '/signalements/create',      SignalementController::class, 'create', ['citoyen']);
$router->add('POST', '/signalements/store',       SignalementController::class, 'store',  ['citoyen']);
$router->add('GET',  '/signalements/{id}',        SignalementController::class, 'show',   ['citoyen','agent','administrateur']);
$router->add('GET',  '/signalements/{id}/edit',   SignalementController::class, 'edit',   ['citoyen']);
$router->add('POST', '/signalements/{id}/update', SignalementController::class, 'update', ['citoyen']);
$router->add('POST', '/signalements/{id}/delete', SignalementController::class, 'delete', ['citoyen']);

// Routes agent
$router->add('GET',  '/agent/dashboard',                AgentController::class, 'dashboard',    ['agent']);
$router->add('POST', '/agent/signalement/{id}/statut',  AgentController::class, 'updateStatut', ['agent']);

// Routes admin
$router->add('GET', '/admin/dashboard', AdminController::class, 'dashboard', ['administrateur']);
$router->add('GET', '/admin/users',     AdminController::class, 'users',     ['administrateur']);
$router->add('POST', '/admin/users/{id}/toggle',
    AdminController::class, 'toggleActif', ['administrateur']);
$router->add('POST', '/admin/users/{id}/role',
    AdminController::class, 'changeRole', ['administrateur']);
$router->add('POST', '/admin/users/{id}/delete',
    AdminController::class, 'deleteUser', ['administrateur']);
$router->add('GET',  '/admin/categories',
    AdminController::class, 'categories', ['administrateur']);
$router->add('GET',  '/admin/export-csv',
    AdminController::class, 'exportCsv', ['administrateur']);

// Commentaires
$router->add('POST', '/signalements/{id}/commentaire',
    CommentaireController::class, 'store',
    ['citoyen','agent','administrateur']);
// Routes API REST (lecture seule - pas besoin d'auth)
$router->add('GET', '/api/signalements',      \App\Controller\ApiController::class, 'signalements');
$router->add('GET', '/api/signalements/{id}', \App\Controller\ApiController::class, 'signalement');
$router->add('GET', '/api/categories',        \App\Controller\ApiController::class, 'categories');
$router->add('GET', '/api/stats',             \App\Controller\ApiController::class, 'stats');

$router->add('GET', '/carte', \App\Controller\CarteController::class, 'index',
    ['citoyen','agent','administrateur']);
// Dispatch
try {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = str_replace('/essaie/public', '', $uri);
    if (empty($uri)) $uri = '/';
    $router->dispatch($_SERVER['REQUEST_METHOD'], $uri);

} catch (\App\Exception\AccessDeniedException $e) {
    http_response_code(403);
    require dirname(__DIR__) . '/views/errors/403.php';
} catch (\App\Exception\EntityNotFoundException $e) {
    http_response_code(404);
    require dirname(__DIR__) . '/views/errors/404.php';
} catch (\Exception $e) {
    http_response_code(500);
    echo '<h1>Erreur serveur</h1><p>' . htmlspecialchars($e->getMessage()) . '</p>';
}
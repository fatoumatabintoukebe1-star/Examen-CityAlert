<?php
use App\Core\Auth;
use App\Core\Session;
$user    = Auth::user();
$success = Session::getFlash('success');
$theme   = '';
if ($user) {
    $theme = match($user['role']) {
        'agent'          => 'theme-agent',
        'administrateur' => 'theme-admin',
        default          => 'theme-citoyen',
    };
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CityAlert — Signalement Citoyen</title>
  <link rel="stylesheet" href="<?= ASSETS_URL ?>/assets/css/style.css">
</head>
<body class="<?= $theme ?>">

<?php if ($user): ?>
<nav class="navbar">
  <a href="<?= BASE_URL ?>/" class="navbar-brand">CityAlert</a>
  <div class="navbar-links">
    <?php if ($user['role'] === 'administrateur'): ?>
      <a href="<?= BASE_URL ?>/admin/dashboard">Dashboard</a>
      <a href="<?= BASE_URL ?>/admin/users">Utilisateurs</a>
      <a href="<?= BASE_URL ?>/admin/categories">Catégories</a>
    <?php elseif ($user['role'] === 'agent'): ?>
      <a href="<?= BASE_URL ?>/agent/dashboard">Mes signalements</a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/signalements">Mes signalements</a>
      <a href="<?= BASE_URL ?>/signalements/create"
         class="btn btn-primary btn-sm">+ Signaler</a>
    <?php endif; ?>
    <a href="<?= BASE_URL ?>/carte">🗺️ Carte</a>
    <span class="navbar-user">
      👤 <?= htmlspecialchars($user['nom']) ?>
    </span>
    <a href="<?= BASE_URL ?>/logout" class="btn btn-outline btn-sm">
      Déconnexion
    </a>
  </div>
</nav>
<?php endif; ?>

<?php if ($success): ?>
  <div class="alert alert-success container">
    <?= htmlspecialchars($success) ?>
  </div>
<?php endif; ?>

<main class="container"></main>
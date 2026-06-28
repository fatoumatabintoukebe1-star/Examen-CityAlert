<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container">
  <div class="auth-card">

    <div class="auth-logo">CityAlert</div>
    <h2>Connexion</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/login">
      <div class="form-group">
        <label for="email">Adresse email</label>
        <input type="email" id="email" name="email"
               placeholder="votre@email.com" required>
      </div>
      <div class="form-group">
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe"
               placeholder="••••••••" required>
      </div>
      <button type="submit" class="btn btn-primary btn-full">
        Se connecter
      </button>
    </form>

    <p class="auth-link">
      Pas encore de compte ?
      <a href="<?= BASE_URL ?>/register">S'inscrire</a>
    </p>

  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-container">
  <div class="auth-card">

    <div class="auth-logo">CityAlert</div>
    <h2>Créer un compte</h2>

    <?php if ($error): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/register">
      <div class="form-row">
        <div class="form-group">
          <label>Prénom</label>
          <input type="text" name="prenom" placeholder="Fatou" required>
        </div>
        <div class="form-group">
          <label>Nom</label>
          <input type="text" name="nom" placeholder="Diallo" required>
        </div>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email"
               placeholder="vous@email.com" required>
      </div>
      <div class="form-group">
        <label>Mot de passe (8 caractères min.)</label>
        <input type="password" name="mot_de_passe" required>
      </div>
      <div class="form-group">
        <label>Confirmer le mot de passe</label>
        <input type="password" name="confirmation" required>
      </div>
      <button type="submit" class="btn btn-primary btn-full">
        Créer mon compte
      </button>
    </form>

    <p class="auth-link">
      Déjà inscrit ?
      <a href="<?= BASE_URL ?>/login">Se connecter</a>
    </p>

  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

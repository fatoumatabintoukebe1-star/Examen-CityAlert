<?php require __DIR__ . '/layout/header.php'; ?>

<div class="hero">
  <div class="hero-content">
    <div class="hero-badge">
      🏙️ Plateforme de signalement citoyen
    </div>
    <h1>Signalez. <span>Suivez.</span> Résolvez.</h1>
    <p>
      CityAlert connecte les citoyens aux services municipaux
      pour une ville plus propre, plus sûre et plus réactive.
    </p>
    <div class="hero-buttons">
      <a href="<?= BASE_URL ?>/register" class="btn-hero-primary">
        Commencer gratuitement →
      </a>
      <a href="<?= BASE_URL ?>/login" class="btn-hero-outline">
        Se connecter
      </a>
    </div>

    <div class="features-grid">
      <div class="feature-card">
        <div class="icon">📍</div>
        <h3>Signalez facilement</h3>
        <p>Créez un signalement en quelques clics avec photo et localisation.</p>
      </div>
      <div class="feature-card">
        <div class="icon">🔧</div>
        <h3>Suivi en temps réel</h3>
        <p>Suivez l'avancement du traitement de votre signalement.</p>
      </div>
      <div class="feature-card">
        <div class="icon">✅</div>
        <h3>Notifications email</h3>
        <p>Soyez notifié par email à chaque changement de statut.</p>
      </div>
      <div class="feature-card">
        <div class="icon">🗺️</div>
        <h3>Carte interactive</h3>
        <p>Visualisez tous les signalements sur une carte en temps réel.</p>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
</main>

<footer class="footer">
  <div style="display:flex;align-items:center;justify-content:center;gap:1rem;flex-wrap:wrap">
    <span>&copy; <?= date('Y') ?> CityAlert — ISEP Diamniadio</span>
    <span style="opacity:.3">•</span>
    <a href="<?= BASE_URL ?>/api/signalements"
       style="color:rgba(255,255,255,.4);font-size:.78rem">
      API REST
    </a>
    <span style="opacity:.3">•</span>
    <a href="<?= BASE_URL ?>/carte"
       style="color:rgba(255,255,255,.4);font-size:.78rem">
      Carte
    </a>
  </div>
</footer>

<script src="<?= ASSETS_URL ?>/assets/js/app.js"></script>
</body>
</html>
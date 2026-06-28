<?php require __DIR__ . '/../layout/header.php'; ?>
<?php use App\Core\Auth; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
  <h2 class="page-title" style="margin:0">Signalements</h2>
  <?php if (Auth::check('citoyen')): ?>
    <a href="<?= BASE_URL ?>/signalements/create" class="btn btn-primary">
      + Nouveau signalement
    </a>
  <?php endif; ?>
</div>

<!-- Filtres -->
<form method="GET" action="<?= BASE_URL ?>/signalements" class="filters">
  <div class="form-group">
    <label>Statut</label>
    <select name="statut">
      <option value="">Tous les statuts</option>
      <option value="Nouveau" <?= ($_GET['statut']??'')==='Nouveau' ? 'selected':'' ?>>Nouveau</option>
      <option value="EnCours" <?= ($_GET['statut']??'')==='EnCours' ? 'selected':'' ?>>En cours</option>
      <option value="Resolu"  <?= ($_GET['statut']??'')==='Resolu'  ? 'selected':'' ?>>Résolu</option>
      <option value="Rejete"  <?= ($_GET['statut']??'')==='Rejete'  ? 'selected':'' ?>>Rejeté</option>
    </select>
  </div>
  <div class="form-group">
    <label>Catégorie</label>
    <select name="categorie_id">
      <option value="">Toutes les catégories</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat->getId() ?>"
          <?= ($_GET['categorie_id']??'')==$cat->getId() ? 'selected':'' ?>>
          <?= htmlspecialchars($cat->getNom()) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Filtrer</button>
  <a href="<?= BASE_URL ?>/signalements" class="btn btn-outline">Réinitialiser</a>
</form>

<!-- Tableau -->
<div class="card">
  <?php if (empty($result['data'])): ?>
    <p style="text-align:center;color:#64748B;padding:2rem">
      Aucun signalement trouvé.
    </p>
  <?php else: ?>
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Statut</th>
            <th>Priorité</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($result['data'] as $sig): ?>
          <tr>
            <td><?= htmlspecialchars($sig->getTitre()) ?></td>
            <td><?= $sig->getCategorieId() ?></td>
            <td>
              <span class="badge <?= $sig->getStatutBadgeClass() ?>">
                <?= $sig->getStatut() ?>
              </span>
            </td>
            <td>
              <span class="badge priorite-<?= $sig->getPriorite() ?>">
                <?= $sig->getPriorite() ?>
              </span>
            </td>
            <td><?= $sig->getCreatedAt()->format('d/m/Y') ?></td>
            <td>
              <a href="<?= BASE_URL ?>/signalements/<?= $sig->getId() ?>"
                 class="btn btn-outline btn-sm">Voir</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if ($result['pages'] > 1): ?>
      <div class="pagination">
        <?php for ($i = 1; $i <= $result['pages']; $i++): ?>
          <a href="<?= BASE_URL ?>/signalements?page=<?= $i ?>
                   <?= !empty($_GET['statut']) ? '&statut='.$_GET['statut'] : '' ?>"
             class="<?= $i == $result['current_page'] ? 'active' : '' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
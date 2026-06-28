<?php require __DIR__ . '/../layout/header.php'; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
  <h2 class="page-title" style="margin:0">📂 Gestion des catégories</h2>
  <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-outline">← Dashboard</a>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Icône</th>
          <th>Nom</th>
          <th>Type</th>
          <th>Délai traitement</th>
          <th>Priorité par défaut</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td style="font-size:1.5rem">
            <?= match($cat->getType()) {
              'voirie'    => '🛣️',
              'eclairage' => '💡',
              'dechets'   => '🗑️',
              'eau'       => '💧',
              default     => '📋'
            } ?>
          </td>
          <td><b><?= htmlspecialchars($cat->getNom()) ?></b></td>
          <td>
            <span class="badge badge-nouveau">
              <?= $cat->getType() ?>
            </span>
          </td>
          <td>
            <span class="badge badge-encours">
              <?= $cat->getDelaiTraitement() ?> jour(s)
            </span>
          </td>
          <td>
            <span class="badge priorite-<?= $cat->getPrioriteDefaut() ?>">
              <?= $cat->getPrioriteDefaut() ?>
            </span>
          </td>
          <td style="color:#64748B;font-size:.9rem">
            <?= htmlspecialchars($cat->getDescription()) ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
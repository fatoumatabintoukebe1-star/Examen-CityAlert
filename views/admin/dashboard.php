<?php require __DIR__ . '/../layout/header.php'; ?>

<h2 class="page-title">📊 Dashboard Administrateur</h2>

<!-- Statistiques globales -->
<div class="stats-grid">
 <div class="stat-card">
   <div class="number"><?= $total ?></div>
   <div class="label">Total signalements</div>
 </div>
 <?php foreach ($stats['par_statut'] as $row): ?>
 <div class="stat-card">
   <div class="number"><?= $row['nb'] ?></div>
   <div class="label"><?= $row['statut'] ?></div>
 </div>
 <?php endforeach; ?>
</div>

<!-- Répartition par catégorie -->
<div class="card" style="margin-bottom:1.5rem">
 <div class="card-header">
   <span class="card-title">📂 Répartition par catégorie</span>
 </div>
 <div class="table-responsive">
   <table>
     <thead>
       <tr>
         <th>Catégorie</th>
         <th>Nombre de signalements</th>
         <th>%</th>
       </tr>
     </thead>
     <tbody>
       <?php foreach ($stats['par_categorie'] as $row): ?>
       <tr>
         <td><?= htmlspecialchars($row['nom']) ?></td>
         <td><?= $row['nb'] ?></td>
         <td><?= $total > 0 ? round($row['nb'] / $total * 100, 1) : 0 ?> %</td>
       </tr>
       <?php endforeach; ?>
     </tbody>
   </table>
 </div>
</div>

<!-- Liens rapides -->
<div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:1rem">
  <a href="<?= BASE_URL ?>/admin/users" class="btn btn-primary">
    👥 Gérer les utilisateurs
  </a>
  <a href="<?= BASE_URL ?>/admin/categories" class="btn btn-primary">
    📂 Gérer les catégories
  </a>
  <a href="<?= BASE_URL ?>/signalements" class="btn btn-outline">
    📋 Voir tous les signalements
  </a>
  <a href="<?= BASE_URL ?>/admin/export-csv" class="btn btn-success">
    📥 Exporter CSV
  </a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
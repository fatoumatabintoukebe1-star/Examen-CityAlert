<?php require __DIR__ . '/../layout/header.php'; ?>

<h2 class="page-title">🔧 Tableau de bord — Agent</h2>

<div class="stats-grid" style="margin-bottom:1.5rem">
 <div class="stat-card">
   <div class="number"><?= count($signalements) ?></div>
   <div class="label">Signalements à traiter</div>
 </div>
 <div class="stat-card">
   <div class="number">
     <?= count(array_filter($signalements, fn($s) => $s->getStatut()==='Nouveau')) ?>
   </div>
   <div class="label">Nouveaux</div>
 </div>
 <div class="stat-card">
   <div class="number">
     <?= count(array_filter($signalements, fn($s) => $s->getStatut()==='EnCours')) ?>
   </div>
   <div class="label">En cours</div>
 </div>
</div>

<div class="card">
 <div class="card-header">
   <span class="card-title">Liste des signalements</span>
 </div>
 <div class="table-responsive">
   <table>
     <thead>
       <tr>
         <th>Titre</th>
         <th>Statut</th>
         <th>Priorité</th>
         <th>Date</th>
         <th>Action</th>
       </tr>
     </thead>
     <tbody>
       <?php foreach ($signalements as $sig): ?>
       <tr>
         <td><?= htmlspecialchars($sig->getTitre()) ?></td>
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
              class="btn btn-primary btn-sm">Traiter</a>
         </td>
       </tr>
       <?php endforeach; ?>
     </tbody>
   </table>
 </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
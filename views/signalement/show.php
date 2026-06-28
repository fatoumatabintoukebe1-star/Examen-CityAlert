<?php require __DIR__ . '/../layout/header.php'; ?>
<?php use App\Core\Auth; ?>

<?php if ($error):   ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<!-- En-tête signalement -->
<div class="signalement-header">
 <h2><?= htmlspecialchars($signalement->getTitre()) ?></h2>
 <div class="signalement-meta">
   <span class="badge <?= $signalement->getStatutBadgeClass() ?>">
     <?= $signalement->getStatut() ?>
   </span>
   <span class="badge priorite-<?= $signalement->getPriorite() ?>">
     <?= $signalement->getPriorite() ?>
   </span>
   <span class="meta-item">
     📍 <?= htmlspecialchars($signalement->getAdresse()) ?>
   </span>
   <span class="meta-item">
     📅 <?= $signalement->getCreatedAt()->format('d/m/Y à H:i') ?>
   </span>
 </div>
</div>

<!-- Description -->
<div class="card" style="margin-bottom:1.5rem">
 <p><?= nl2br(htmlspecialchars($signalement->getDescription())) ?></p>

 <?php if (
   Auth::check('citoyen') &&
   $signalement->estModifiable() &&
   $signalement->getCitoyenId() === Auth::user()['id']
 ): ?>
   <div style="margin-top:1rem;display:flex;gap:.5rem">
     <a href="<?= BASE_URL ?>/signalements/<?= $signalement->getId() ?>/edit"
        class="btn btn-outline btn-sm">✏️ Modifier</a>
     <form method="POST"
           action="<?= BASE_URL ?>/signalements/<?= $signalement->getId() ?>/delete"
           onsubmit="return confirm('Supprimer ce signalement ?')">
       <button class="btn btn-danger btn-sm">🗑️ Supprimer</button>
     </form>
   </div>
 <?php endif; ?>
</div>

<!-- Formulaire changement de statut (agent uniquement) -->
<?php if (Auth::check('agent')): ?>
<div class="card" style="margin-bottom:1.5rem">
 <div class="card-header">
   <span class="card-title">🔧 Changer le statut</span>
 </div>
 <form method="POST"
       action="<?= BASE_URL ?>/agent/signalement/<?= $signalement->getId() ?>/statut">
   <div class="form-row">
     <div class="form-group">
       <label>Nouveau statut</label>
       <select name="statut">
         <option value="EnCours">En cours de traitement</option>
         <option value="Resolu">Résolu</option>
         <option value="Rejete">Rejeté</option>
       </select>
     </div>
     <div class="form-group">
       <label>Commentaire (facultatif)</label>
       <input type="text" name="commentaire"
              placeholder="Remarque sur le traitement...">
     </div>
   </div>
   <button type="submit" class="btn btn-success">Valider le changement</button>
 </form>
</div>
<?php endif; ?>

<!-- Historique des statuts -->
<?php if (!empty($historique)): ?>
<div class="card" style="margin-bottom:1.5rem">
 <div class="card-header">
   <span class="card-title">📜 Historique</span>
 </div>
 <?php foreach ($historique as $h): ?>
   <div style="padding:.6rem 0;border-bottom:1px solid #E2E8F0;font-size:.88rem">
     <b><?= htmlspecialchars($h['prenom'].' '.$h['nom']) ?></b>
     : <?= $h['ancien_statut'] ?> →
     <b><?= $h['nouveau_statut'] ?></b>
     <span style="color:#64748B;margin-left:.5rem">
       <?= date('d/m/Y H:i', strtotime($h['date_changement'])) ?>
     </span>
     <?php if ($h['commentaire']): ?>
       <br><span style="color:#475569">
         <?= htmlspecialchars($h['commentaire']) ?>
       </span>
     <?php endif; ?>
   </div>
 <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Commentaires -->
<div class="card" id="commentaires">
 <div class="card-header">
   <span class="card-title">
     💬 Commentaires (<?= count($commentaires) ?>)
   </span>
 </div>

 <?php if (empty($commentaires)): ?>
   <p style="color:#64748B;font-size:.9rem">Aucun commentaire pour l'instant.</p>
 <?php else: ?>
   <?php foreach ($commentaires as $c): ?>
     <div class="commentaire <?= $c->getAuteurRole()==='agent' ? 'agent-comment' : '' ?>">
       <div class="meta">
         <b><?= htmlspecialchars($c->getAuteurNom()) ?></b>
         <?php if ($c->getAuteurRole()==='agent'): ?>
           <span class="badge badge-encours" style="font-size:.7rem">Agent</span>
         <?php endif; ?>
         · <?= $c->getCreatedAt()->format('d/m/Y à H:i') ?>
       </div>
       <p><?= nl2br(htmlspecialchars($c->getContenu())) ?></p>
     </div>
   <?php endforeach; ?>
 <?php endif; ?>

 <!-- Formulaire ajout commentaire -->
 <form method="POST"
       action="<?= BASE_URL ?>/signalements/<?= $signalement->getId() ?>/commentaire"
       style="margin-top:1.2rem">
   <div class="form-group">
     <label>Ajouter un commentaire</label>
     <textarea name="contenu" placeholder="Votre message..." required></textarea>
   </div>
   <button type="submit" class="btn btn-primary">Envoyer</button>
 </form>
</div>

<div style="margin-top:1rem">
 <a href="<?= BASE_URL ?>/signalements" class="btn btn-outline">
   ← Retour à la liste
 </a>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
<?php require __DIR__ . '/../layout/header.php'; ?>

<h2 class="page-title">Nouveau signalement</h2>

<?php if ($error): ?>
 <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
 <form method="POST" action="<?= BASE_URL ?>/signalements/store">

   <div class="form-group">
     <label for="titre">Titre du problème *</label>
     <input type="text" id="titre" name="titre"
            placeholder="Ex: Nid de poule avenue Cheikh Anta Diop"
            required>
   </div>

   <div class="form-row">
     <div class="form-group">
       <label for="categorie_id">Catégorie *</label>
       <select id="categorie_id" name="categorie_id" required>
         <option value="">-- Choisir une catégorie --</option>
         <?php foreach ($categories as $cat): ?>
           <option value="<?= $cat->getId() ?>">
             <?= htmlspecialchars($cat->getNom()) ?>
             (délai : <?= $cat->getDelaiTraitement() ?> j)
           </option>
         <?php endforeach; ?>
       </select>
     </div>
     <div class="form-group">
       <label for="adresse">Adresse / Localisation *</label>
       <input type="text" id="adresse" name="adresse"
              placeholder="Ex: Rue 10, Quartier Diamniadio"
              required>
     </div>
   </div>

   <div class="form-group">
     <label for="description">Description détaillée *</label>
     <textarea id="description" name="description"
               placeholder="Décrivez le problème avec le plus de détails possible..."
               required></textarea>
   </div>

   <div style="display:flex;gap:1rem;margin-top:1rem">
     <button type="submit" class="btn btn-primary">
       Envoyer le signalement
     </button>
     <a href="<?= BASE_URL ?>/signalements" class="btn btn-outline">
       Annuler
     </a>
   </div>

 </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
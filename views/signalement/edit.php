<?php require __DIR__ . '/../layout/header.php'; ?>

<h2 class="page-title">✏️ Modifier le signalement</h2>

<div class="card">
 <form method="POST"
       action="<?= BASE_URL ?>/signalements/<?= $signalement->getId() ?>/update">

   <div class="form-group">
     <label for="titre">Titre *</label>
     <input type="text" id="titre" name="titre"
            value="<?= htmlspecialchars($signalement->getTitre()) ?>"
            required>
   </div>

   <div class="form-row">
     <div class="form-group">
       <label for="categorie_id">Catégorie *</label>
       <select id="categorie_id" name="categorie_id" required>
         <?php foreach ($categories as $cat): ?>
           <option value="<?= $cat->getId() ?>"
             <?= $cat->getId() === $signalement->getCategorieId() ? 'selected' : '' ?>>
             <?= htmlspecialchars($cat->getNom()) ?>
           </option>
         <?php endforeach; ?>
       </select>
     </div>
     <div class="form-group">
       <label for="adresse">Adresse *</label>
       <input type="text" id="adresse" name="adresse"
              value="<?= htmlspecialchars($signalement->getAdresse()) ?>"
              required>
     </div>
   </div>

   <div class="form-group">
     <label for="description">Description *</label>
     <textarea id="description" name="description" required><?= htmlspecialchars($signalement->getDescription()) ?></textarea>
   </div>

   <div style="display:flex;gap:1rem;margin-top:1rem">
     <button type="submit" class="btn btn-primary">
       💾 Enregistrer
     </button>
     <a href="<?= BASE_URL ?>/signalements/<?= $signalement->getId() ?>"
        class="btn btn-outline">Annuler</a>
   </div>

 </form>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>

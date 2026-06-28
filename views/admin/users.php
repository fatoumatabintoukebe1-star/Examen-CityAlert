<?php require __DIR__ . '/../layout/header.php'; ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem">
  <h2 class="page-title" style="margin:0">👥 Gestion des utilisateurs</h2>
  <a href="<?= BASE_URL ?>/admin/dashboard" class="btn btn-outline">← Dashboard</a>
</div>

<?php if ($success): ?>
  <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Nom complet</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Inscrit le</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><b><?= htmlspecialchars($u->getNomComplet()) ?></b></td>
          <td><?= htmlspecialchars($u->getEmail()) ?></td>
          <td>
            <!-- Changer le rôle -->
            <form method="POST"
                  action="<?= BASE_URL ?>/admin/users/<?= $u->getId() ?>/role"
                  style="display:inline">
              <select name="role" onchange="this.form.submit()"
                      style="font-size:.8rem;padding:.2rem .5rem;border-radius:6px;border:1px solid #CBD5E1">
                <option value="citoyen"
                  <?= $u->getRole()==='citoyen' ? 'selected':'' ?>>
                  Citoyen
                </option>
                <option value="agent"
                  <?= $u->getRole()==='agent' ? 'selected':'' ?>>
                  Agent
                </option>
                <option value="administrateur"
                  <?= $u->getRole()==='administrateur' ? 'selected':'' ?>>
                  Admin
                </option>
              </select>
            </form>
          </td>
          <td><?= $u->getCreatedAt()?->format('d/m/Y') ?? 'N/A' ?></td>
          <td>
            <span class="badge <?= $u->isActif() ? 'badge-resolu':'badge-rejete' ?>">
              <?= $u->isActif() ? 'Actif':'Inactif' ?>
            </span>
          </td>
          <td style="display:flex;gap:.4rem;flex-wrap:wrap;align-items:center">
    
    <!-- Switch Activer/Désactiver -->
    <form method="POST"
          action="<?= BASE_URL ?>/admin/users/<?= $u->getId() ?>/toggle">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
            <div style="position:relative">
                <input type="checkbox" 
                       <?= $u->isActif() ? 'checked' : '' ?>
                       onchange="this.form.submit()"
                       style="opacity:0;width:0;height:0;position:absolute">
                <div style="
                    width:44px;height:24px;
                    background:<?= $u->isActif() ? '#16A34A' : '#DC2626' ?>;
                    border-radius:12px;
                    transition:background .3s;
                    display:flex;align-items:center;
                    padding:2px">
                    <div style="
                        width:20px;height:20px;
                        background:#fff;border-radius:50%;
                        transform:<?= $u->isActif() ? 'translateX(20px)' : 'translateX(0)' ?>;
                        transition:transform .3s">
                    </div>
                </div>
            </div>
            <span style="font-size:.82rem;color:<?= $u->isActif() ? '#16A34A' : '#DC2626' ?>">
                <?= $u->isActif() ? 'Actif' : 'Inactif' ?>
            </span>
        </label>
    </form>

    <!-- Supprimer -->
    <form method="POST"
          action="<?= BASE_URL ?>/admin/users/<?= $u->getId() ?>/delete"
          onsubmit="return confirm('Supprimer cet utilisateur ?')">
        <button type="submit" class="btn btn-danger btn-sm">
            🗑️ Supprimer
        </button>
    </form>

</td>
          
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
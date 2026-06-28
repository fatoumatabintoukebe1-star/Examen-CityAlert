<?php require __DIR__ . '/layout/header.php'; ?>

<h2 class="page-title">🗺️ Carte des signalements</h2>

<!-- Légende -->
<div style="display:flex;gap:1rem;flex-wrap:wrap;margin-bottom:1.5rem">
  <span style="display:flex;align-items:center;gap:.4rem;font-size:.9rem">
    <span style="background:#DC2626;width:12px;height:12px;border-radius:50%;display:inline-block"></span> Nouveau
  </span>
  <span style="display:flex;align-items:center;gap:.4rem;font-size:.9rem">
    <span style="background:#D97706;width:12px;height:12px;border-radius:50%;display:inline-block"></span> En cours
  </span>
  <span style="display:flex;align-items:center;gap:.4rem;font-size:.9rem">
    <span style="background:#16A34A;width:12px;height:12px;border-radius:50%;display:inline-block"></span> Résolu
  </span>
  <span style="display:flex;align-items:center;gap:.4rem;font-size:.9rem">
    <span style="background:#475569;width:12px;height:12px;border-radius:50%;display:inline-block"></span> Rejeté
  </span>
</div>

<!-- Carte -->
<div class="card" style="padding:0;overflow:hidden">
  <div id="map" style="height:550px;width:100%"></div>
</div>

<!-- Stats sous la carte -->
<div class="stats-grid" style="margin-top:1.5rem">
  <div class="stat-card">
    <div class="number"><?= count($signalements) ?></div>
    <div class="label">Total sur la carte</div>
  </div>
  <div class="stat-card">
    <div class="number">
      <?= count(array_filter($signalements, fn($s) => $s->getLatitude() !== null)) ?>
    </div>
    <div class="label">Avec localisation GPS</div>
  </div>
  <div class="stat-card">
    <div class="number">
      <?= count(array_filter($signalements, fn($s) => $s->getStatut() === 'Nouveau')) ?>
    </div>
    <div class="label">En attente</div>
  </div>
</div>

<!-- Leaflet CSS et JS -->
<link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Initialiser la carte centrée sur Dakar/Diamniadio
var map = L.map('map').setView([14.7167, -17.4677], 11);

// Fond de carte OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
    maxZoom: 19,
}).addTo(map);

// Couleurs selon le statut
function getColor(statut) {
    switch(statut) {
        case 'Nouveau':  return '#DC2626';
        case 'EnCours':  return '#D97706';
        case 'Resolu':   return '#16A34A';
        case 'Rejete':   return '#475569';
        default:         return '#2563EB';
    }
}

// Icône personnalisée
function makeIcon(statut) {
    return L.divIcon({
        className: '',
        html: `<div style="
            background:${getColor(statut)};
            width:16px;height:16px;
            border-radius:50%;
            border:3px solid #fff;
            box-shadow:0 2px 6px rgba(0,0,0,.4)">
        </div>`,
        iconSize: [16, 16],
        iconAnchor: [8, 8],
        popupAnchor: [0, -10],
    });
}

// Données PHP → JavaScript
var signalements = <?= json_encode(
    array_values(array_filter(
        array_map(fn($s) => $s->getLatitude() !== null ? [
            'id'       => $s->getId(),
            'titre'    => $s->getTitre(),
            'adresse'  => $s->getAdresse(),
            'statut'   => $s->getStatut(),
            'priorite' => $s->getPriorite(),
            'lat'      => $s->getLatitude(),
            'lng'      => $s->getLongitude(),
        ] : null, $signalements),
        fn($s) => $s !== null
    )),
    JSON_UNESCAPED_UNICODE
) ?>;

// Ajouter les marqueurs
signalements.forEach(function(s) {
    var marker = L.marker([s.lat, s.lng], {icon: makeIcon(s.statut)});
    marker.bindPopup(`
        <div style="min-width:200px;font-family:Arial,sans-serif">
            <h3 style="margin:0 0 8px;color:#1E3A5F;font-size:1rem">
                ${s.titre}
            </h3>
            <p style="margin:0 0 6px;color:#475569;font-size:.85rem">
                📍 ${s.adresse}
            </p>
            <div style="display:flex;gap:6px;margin-bottom:8px">
                <span style="
                    background:${getColor(s.statut)};
                    color:#fff;padding:2px 8px;
                    border-radius:12px;font-size:.75rem">
                    ${s.statut}
                </span>
                <span style="
                    background:#E2E8F0;
                    color:#475569;padding:2px 8px;
                    border-radius:12px;font-size:.75rem">
                    ${s.priorite}
                </span>
            </div>
            <a href="<?= BASE_URL ?>/signalements/${s.id}"
               style="color:#2563EB;font-size:.85rem">
               Voir le détail →
            </a>
        </div>
    `);
    marker.addTo(map);
});

// Si aucun marqueur, afficher un message
if (signalements.length === 0) {
    map.setView([14.7167, -17.4677], 11);
}
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>
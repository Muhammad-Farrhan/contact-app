<?php
require_once __DIR__ . '/../includes/header.php';

$view = $_GET['view'] ?? 'A';
$validViews = ['A','B','C','D'];
if (!in_array($view, $validViews)) $view = 'A';

$queries = [
  'A' => [
    'label' => 'Semua Data',
    'sql'   => "SELECT c.title, c.name,
                       COALESCE(GROUP_CONCAT(DISTINCT p.phone_number SEPARATOR ', '), '-') AS no_telp,
                       COALESCE(GROUP_CONCAT(DISTINCT g.group_name    SEPARATOR ', '), '-') AS group_name
                FROM contacts c
                LEFT JOIN contact_phones p             ON p.contact_id = c.contact_id
                LEFT JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
                LEFT JOIN group_master g               ON g.group_id = cgm.group_id
                GROUP BY c.contact_id, c.title, c.name
                ORDER BY c.name",
    'cols'  => ['title','name','no_telp','group_name']
  ],
  'B' => [
    'label' => 'Priority HIGH',
    'sql'   => "SELECT c.title, c.name,
                       COALESCE(GROUP_CONCAT(DISTINCT p.phone_number SEPARATOR ', '), '-') AS no_telp
                FROM contacts c
                JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
                JOIN group_master g               ON g.group_id    = cgm.group_id
                LEFT JOIN contact_phones p        ON p.contact_id  = c.contact_id
                WHERE g.priority = 'high'
                GROUP BY c.contact_id, c.title, c.name
                ORDER BY c.name",
    'cols'  => ['title','name','no_telp']
  ],
  'C' => [
    'label' => 'Belum Punya Group',
    'sql'   => "SELECT c.title, c.name,
                       COALESCE(GROUP_CONCAT(DISTINCT p.phone_number SEPARATOR ', '), '-') AS no_telp
                FROM contacts c
                LEFT JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
                LEFT JOIN contact_phones p             ON p.contact_id = c.contact_id
                WHERE cgm.contact_id IS NULL
                GROUP BY c.contact_id, c.title, c.name
                ORDER BY c.name",
    'cols'  => ['title','name','no_telp']
  ],
  'D' => [
    'label' => 'Group Kosong',
    'sql'   => "SELECT g.group_name, g.priority
                FROM group_master g
                LEFT JOIN contact_group_membership cgm ON cgm.group_id = g.group_id
                WHERE cgm.group_id IS NULL
                ORDER BY g.group_name",
    'cols'  => ['group_name','priority']
  ],
];

$current = $queries[$view];
$rows    = $pdo->query($current['sql'])->fetchAll();

$pageTitle = 'Laporan';
?>

<h3 class="mb-3"><i class="bi bi-bar-chart"></i> Laporan</h3>

<ul class="nav nav-tabs mb-3">
  <?php foreach ($queries as $k => $q): ?>
    <li class="nav-item">
      <a class="nav-link <?= $view===$k?'active':'' ?>" href="?view=<?= $k ?>">
        <strong><?= $k ?>.</strong> <?= e($q['label']) ?>
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<div class="card">
  <div class="card-header bg-white">
    <strong>Query <?= $view ?></strong> — <?= e($current['label']) ?>
    <span class="badge bg-secondary ms-2"><?= count($rows) ?> baris</span>
  </div>
  <div class="table-responsive">
    <table class="table table-striped mb-0">
      <thead class="table-light">
        <tr>
          <?php foreach ($current['cols'] as $col): ?>
            <th><?= ucwords(str_replace('_', ' ', $col)) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="<?= count($current['cols']) ?>" class="text-center text-muted py-4">
          Tidak ada data.</td></tr>
      <?php else: foreach ($rows as $r): ?>
        <tr>
          <?php foreach ($current['cols'] as $col): ?>
            <td><?= e($r[$col] ?? '-') ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
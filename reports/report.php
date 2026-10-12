<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$view = $_GET['view'] ?? 'A';

$queries = [
  'A' => [
    'title' => 'A. Semua Contact (Title, Name, No Telp, Group)',
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
    'title' => 'B. Contact pada Group Priority HIGH',
    'sql'   => "SELECT c.title, c.name,
                       COALESCE(GROUP_CONCAT(DISTINCT p.phone_number SEPARATOR ', '), '-') AS no_telp
                FROM contacts c
                JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
                JOIN group_master g               ON g.group_id = cgm.group_id
                LEFT JOIN contact_phones p        ON p.contact_id = c.contact_id
                WHERE g.priority = 'high'
                GROUP BY c.contact_id, c.title, c.name
                ORDER BY c.name",
    'cols'  => ['title','name','no_telp']
  ],
  'C' => [
    'title' => 'C. Contact yang Belum Terdaftar di Group',
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
    'title' => 'D. Group yang Belum Punya Contact',
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
?>

<h3>Laporan</h3>

<ul class="nav nav-tabs mb-3">
  <?php foreach ($queries as $key => $q): ?>
    <li class="nav-item">
      <a class="nav-link <?= $view === $key ? 'active' : '' ?>"
         href="?view=<?= $key ?>"><?= htmlspecialchars($q['title']) ?></a>
    </li>
  <?php endforeach; ?>
</ul>

<h5><?= htmlspecialchars($current['title']) ?></h5>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <?php foreach ($current['cols'] as $col): ?>
        <th><?= ucwords(str_replace('_', ' ', $col)) ?></th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($rows)): ?>
      <tr>
        <td colspan="<?= count($current['cols']) ?>" class="text-center text-muted">
          Tidak ada data.
        </td>
      </tr>
    <?php else: ?>
      <?php foreach ($rows as $r): ?>
        <tr>
          <?php foreach ($current['cols'] as $col): ?>
            <td><?= htmlspecialchars($r[$col] ?? '-') ?></td>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
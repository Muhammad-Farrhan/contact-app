<?php
require_once __DIR__ . '/../includes/header.php';

$contacts = $pdo->query("SELECT contact_id, title, name FROM contacts ORDER BY name")->fetchAll();
$groups   = $pdo->query("SELECT group_id, group_name, priority FROM group_master
                         ORDER BY CASE priority WHEN 'high' THEN 1 WHEN 'med' THEN 2 ELSE 3 END, group_name")->fetchAll();

// Map [contact_id][group_id] = true
$map = [];
foreach ($pdo->query("SELECT contact_id, group_id FROM contact_group_membership") as $r) {
    $map[$r['contact_id']][$r['group_id']] = true;
}

$pageTitle = 'Assignments';
?>

<h3 class="mb-3"><i class="bi bi-diagram-3"></i> Matrix Contact × Group</h3>
<p class="text-muted">Klik nama contact untuk mengatur group yang diikuti.</p>

<div class="card">
  <div class="table-responsive">
    <table class="table table-bordered table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th>Contact</th>
          <?php foreach ($groups as $g): ?>
            <th class="text-center">
              <?= e($g['group_name']) ?><br>
              <span class="badge badge-<?= $g['priority'] ?>"><?= strtoupper($g['priority']) ?></span>
            </th>
          <?php endforeach; ?>
          <th width="80" class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($contacts as $c): ?>
        <tr>
          <td>
            <a href="edit.php?id=<?= $c['contact_id'] ?>">
              <strong><?= e($c['title'].' '.$c['name']) ?></strong>
            </a>
          </td>
          <?php foreach ($groups as $g): ?>
            <td class="text-center">
              <?php if (!empty($map[$c['contact_id']][$g['group_id']])): ?>
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
              <?php else: ?>
                <i class="bi bi-dash text-muted"></i>
              <?php endif; ?>
            </td>
          <?php endforeach; ?>
          <td class="text-center">
            <a href="edit.php?id=<?= $c['contact_id'] ?>" class="btn btn-sm btn-warning">
              <i class="bi bi-pencil"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
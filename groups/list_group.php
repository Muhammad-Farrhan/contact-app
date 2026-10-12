<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$sql = "SELECT g.group_id, g.group_name, g.priority,
               COUNT(cgm.contact_id) AS total_contact
        FROM group_master g
        LEFT JOIN contact_group_membership cgm ON cgm.group_id = g.group_id
        GROUP BY g.group_id, g.group_name, g.priority
        ORDER BY
            CASE g.priority WHEN 'high' THEN 1 WHEN 'med' THEN 2 ELSE 3 END,
            g.group_name";
$rows = $pdo->query($sql)->fetchAll();
?>

<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Group</h3>
  <a href="form_group.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Group</a>
</div>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th width="60">ID</th><th>Group Name</th><th>Priority</th>
      <th>Total Contact</th><th width="160">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= $r['group_id'] ?></td>
        <td><?= htmlspecialchars($r['group_name']) ?></td>
        <td>
          <span class="badge bg-<?= $r['priority']==='high' ? 'danger' : ($r['priority']==='med' ? 'warning' : 'secondary') ?>">
            <?= strtoupper($r['priority']) ?>
          </span>
        </td>
        <td><?= $r['total_contact'] ?></td>
        <td>
          <a href="form_group.php?id=<?= $r['group_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete_group.php?id=<?= $r['group_id'] ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('Hapus group ini?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
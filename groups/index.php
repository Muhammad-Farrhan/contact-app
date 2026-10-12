<?php
require_once __DIR__ . '/../includes/header.php';

$rows = $pdo->query("
    SELECT g.*, COUNT(cgm.contact_id) AS total
    FROM group_master g
    LEFT JOIN contact_group_membership cgm ON cgm.group_id = g.group_id
    GROUP BY g.group_id, g.group_name, g.priority
    ORDER BY CASE g.priority WHEN 'high' THEN 1 WHEN 'med' THEN 2 ELSE 3 END, g.group_name
")->fetchAll();

$pageTitle = 'Daftar Group';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><i class="bi bi-collection"></i> Daftar Group</h3>
  <a href="create.php" class="btn btn-success">
    <i class="bi bi-plus-circle"></i> Tambah Group
  </a>
</div>

<div class="card">
  <table class="table table-hover mb-0">
    <thead class="table-light">
      <tr>
        <th width="60">ID</th><th>Group Name</th><th width="120">Priority</th>
        <th width="130">Jml Contact</th><th width="180" class="text-end">Aksi</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= $r['group_id'] ?></td>
        <td><strong><?= e($r['group_name']) ?></strong></td>
        <td><span class="badge badge-<?= $r['priority'] ?>"><?= strtoupper($r['priority']) ?></span></td>
        <td><?= $r['total'] ?></td>
        <td class="text-end">
          <a href="<?= BASE_URL ?>/reports/index.php?view=B" class="btn btn-sm btn-outline-info" title="Lihat Contact">
            <i class="bi bi-eye"></i>
          </a>
          <a href="edit.php?id=<?= $r['group_id'] ?>" class="btn btn-sm btn-outline-warning">
            <i class="bi bi-pencil"></i>
          </a>
          <a href="delete.php?id=<?= $r['group_id'] ?>" class="btn btn-sm btn-outline-danger"
             onclick="return confirm('Hapus group <?= e($r['group_name']) ?>?')">
            <i class="bi bi-trash"></i>
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
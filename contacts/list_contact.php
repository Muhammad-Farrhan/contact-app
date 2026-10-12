<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$sql = "SELECT
            c.contact_id, c.title, c.name,
            COALESCE(GROUP_CONCAT(DISTINCT p.phone_number SEPARATOR ', '), '-') AS phones,
            COALESCE(GROUP_CONCAT(DISTINCT CONCAT(g.group_name, ' (', g.priority, ')') SEPARATOR ', '), '-') AS groups
        FROM contacts c
        LEFT JOIN contact_phones p             ON p.contact_id = c.contact_id
        LEFT JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
        LEFT JOIN group_master g               ON g.group_id = cgm.group_id
        GROUP BY c.contact_id, c.title, c.name
        ORDER BY c.name";
$rows = $pdo->query($sql)->fetchAll();
?>

<div class="d-flex justify-content-between mb-3">
  <h3>Daftar Contact</h3>
  <a href="form_contact.php" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Tambah Contact
  </a>
</div>

<?php if (isset($_GET['msg'])): ?>
  <div class="alert alert-success">
    Data berhasil di<?= $_GET['msg'] === 'created' ? 'tambah' : 'update' ?>.
  </div>
<?php endif; ?>

<table class="table table-bordered table-striped">
  <thead class="table-dark">
    <tr>
      <th width="60">ID</th><th>Title</th><th>Name</th>
      <th>No Telp</th><th>Group</th><th width="160">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rows as $r): ?>
      <tr>
        <td><?= $r['contact_id'] ?></td>
        <td><?= htmlspecialchars($r['title']) ?></td>
        <td><?= htmlspecialchars($r['name']) ?></td>
        <td><?= htmlspecialchars($r['phones']) ?></td>
        <td><?= htmlspecialchars($r['groups']) ?></td>
        <td>
          <a href="form_contact.php?id=<?= $r['contact_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete_contact.php?id=<?= $r['contact_id'] ?>"
             class="btn btn-sm btn-danger"
             onclick="return confirm('Hapus contact ini?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
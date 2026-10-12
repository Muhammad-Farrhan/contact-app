<?php
require_once __DIR__ . '/../includes/header.php';

$search = $_GET['q'] ?? '';

$sql = "SELECT c.contact_id, c.title, c.name,
               COALESCE(GROUP_CONCAT(DISTINCT p.phone_number ORDER BY p.is_primary DESC SEPARATOR ', '), '-') AS phones,
               COALESCE(GROUP_CONCAT(DISTINCT g.group_name SEPARATOR ', '), '-') AS groups
        FROM contacts c
        LEFT JOIN contact_phones p             ON p.contact_id = c.contact_id
        LEFT JOIN contact_group_membership cgm ON cgm.contact_id = c.contact_id
        LEFT JOIN group_master g               ON g.group_id = cgm.group_id";

if ($search !== '') {
    $sql .= " WHERE c.name LIKE :q ";
}
$sql .= " GROUP BY c.contact_id, c.title, c.name ORDER BY c.name";

$stmt = $pdo->prepare($sql);
if ($search !== '') $stmt->bindValue(':q', "%$search%");
$stmt->execute();
$rows = $stmt->fetchAll();

$pageTitle = 'Daftar Contact';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0"><i class="bi bi-people"></i> Daftar Contact</h3>
  <a href="create.php" class="btn btn-primary">
    <i class="bi bi-plus-circle"></i> Tambah Contact
  </a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-4">
    <input type="text" name="q" value="<?= e($search) ?>" class="form-control" placeholder="Cari nama contact...">
  </div>
  <div class="col-md-2">
    <button class="btn btn-outline-secondary w-100"><i class="bi bi-search"></i> Cari</button>
  </div>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th width="60">ID</th>
          <th width="80">Title</th>
          <th>Name</th>
          <th>No Telp</th>
          <th>Group</th>
          <th width="180" class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada contact.</td></tr>
      <?php else: foreach ($rows as $r): ?>
        <tr>
          <td><?= $r['contact_id'] ?></td>
          <td><?= e($r['title']) ?></td>
          <td><strong><?= e($r['name']) ?></strong></td>
          <td><?= e($r['phones']) ?></td>
          <td><?= e($r['groups']) ?></td>
          <td class="text-end">
            <a href="<?= BASE_URL ?>/assignments/edit.php?id=<?= $r['contact_id'] ?>" class="btn btn-sm btn-outline-info" title="Assign Group">
              <i class="bi bi-diagram-3"></i>
            </a>
            <a href="edit.php?id=<?= $r['contact_id'] ?>" class="btn btn-sm btn-outline-warning">
              <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="delete.php?id=<?= $r['contact_id'] ?>"
               class="btn btn-sm btn-outline-danger"
               onclick="return confirm('Hapus contact <?= e($r['name']) ?>?')">
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
      <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
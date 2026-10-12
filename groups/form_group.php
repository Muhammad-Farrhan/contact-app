<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$edit = false;
$data = ['group_id' => '', 'group_name' => '', 'priority' => 'med'];

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $pdo->prepare("SELECT * FROM group_master WHERE group_id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $data = $stmt->fetch();
}
?>

<h3><?= $edit ? 'Edit' : 'Tambah' ?> Group</h3>

<form action="save_group.php" method="POST">
  <input type="hidden" name="group_id" value="<?= htmlspecialchars($data['group_id']) ?>">

  <div class="mb-3">
    <label class="form-label">Group Name <span class="text-danger">*</span></label>
    <input type="text" name="group_name" class="form-control" required maxlength="100"
           value="<?= htmlspecialchars($data['group_name']) ?>"
           placeholder="Contoh: Supplier">
  </div>

  <div class="mb-3">
    <label class="form-label">Priority <span class="text-danger">*</span></label>
    <select name="priority" class="form-select" required>
      <option value="low"  <?= $data['priority']==='low'  ? 'selected':'' ?>>Low</option>
      <option value="med"  <?= $data['priority']==='med'  ? 'selected':'' ?>>Medium</option>
      <option value="high" <?= $data['priority']==='high' ? 'selected':'' ?>>High</option>
    </select>
  </div>

  <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
  <a href="list_group.php" class="btn btn-secondary">Batal</a>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
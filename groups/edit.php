<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM group_master WHERE group_id = ?");
$stmt->execute([$id]);
$g = $stmt->fetch();

if (!$g) {
    setFlash('error', 'Group tidak ditemukan.');
    redirect('/groups/index.php');
}

$pageTitle = 'Edit Group';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Group</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</nav>

<h3 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Group</h3>

<form action="save.php" method="POST" class="card p-4">
  <input type="hidden" name="group_id" value="<?= $g['group_id'] ?>">

  <div class="mb-3">
    <label class="form-label">Group Name <span class="text-danger">*</span></label>
    <input type="text" name="group_name" class="form-control" required maxlength="100"
           value="<?= e($g['group_name']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label d-block">Priority <span class="text-danger">*</span></label>
    <?php foreach (['low'=>'Low','med'=>'Medium','high'=>'High'] as $v=>$l): ?>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="priority" value="<?= $v ?>"
               id="p-<?= $v ?>" required <?= $g['priority']===$v?'checked':'' ?>>
        <label class="form-check-label" for="p-<?= $v ?>"><?= $l ?></label>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-success"><i class="bi bi-save"></i> Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
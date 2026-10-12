<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE contact_id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch();

if (!$c) {
    setFlash('error', 'Contact tidak ditemukan.');
    redirect('/assignments/index.php');
}

$groups = $pdo->query("SELECT * FROM group_master
                       ORDER BY CASE priority WHEN 'high' THEN 1 WHEN 'med' THEN 2 ELSE 3 END, group_name")->fetchAll();

$stmt = $pdo->prepare("SELECT group_id FROM contact_group_membership WHERE contact_id = ?");
$stmt->execute([$id]);
$owned = array_column($stmt->fetchAll(), 'group_id');

$pageTitle = 'Assign Group';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Assignments</a></li>
    <li class="breadcrumb-item active"><?= e($c['name']) ?></li>
  </ol>
</nav>

<h3 class="mb-3"><i class="bi bi-diagram-3"></i> Assign Group untuk <?= e($c['title'].' '.$c['name']) ?></h3>

<form action="save.php" method="POST" class="card p-4">
  <input type="hidden" name="contact_id" value="<?= $c['contact_id'] ?>">

  <p class="text-muted mb-3">Centang group yang ingin diikuti (boleh lebih dari satu).</p>

  <div class="row">
    <?php foreach ($groups as $g): ?>
      <div class="col-md-6 mb-2">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="group_ids[]"
                 value="<?= $g['group_id'] ?>" id="g<?= $g['group_id'] ?>"
                 <?= in_array($g['group_id'], $owned) ? 'checked' : '' ?>>
          <label class="form-check-label" for="g<?= $g['group_id'] ?>">
            <?= e($g['group_name']) ?>
            <span class="badge badge-<?= $g['priority'] ?>"><?= strtoupper($g['priority']) ?></span>
          </label>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <hr>
  <div class="d-flex gap-2">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
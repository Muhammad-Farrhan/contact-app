<?php
require_once __DIR__ . '/includes/header.php';

$totalContacts = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
$totalGroups   = $pdo->query("SELECT COUNT(*) FROM group_master")->fetchColumn();
$totalPhones   = $pdo->query("SELECT COUNT(*) FROM contact_phones")->fetchColumn();
$totalAssign   = $pdo->query("SELECT COUNT(*) FROM contact_group_membership")->fetchColumn();

$pageTitle = 'Dashboard';
?>

<h3 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h3>

<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card text-bg-primary">
      <div class="card-body">
        <h5 class="card-title"><?= $totalContacts ?></h5>
        <p class="card-text mb-0"><i class="bi bi-people-fill"></i> Total Contact</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-bg-success">
      <div class="card-body">
        <h5 class="card-title"><?= $totalGroups ?></h5>
        <p class="card-text mb-0"><i class="bi bi-collection-fill"></i> Total Group</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-bg-warning">
      <div class="card-body">
        <h5 class="card-title"><?= $totalPhones ?></h5>
        <p class="card-text mb-0"><i class="bi bi-telephone-fill"></i> Total No Telp</p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card text-bg-danger">
      <div class="card-body">
        <h5 class="card-title"><?= $totalAssign ?></h5>
        <p class="card-text mb-0"><i class="bi bi-diagram-3-fill"></i> Assignment</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-3">
    <a href="<?= BASE_URL ?>/contacts/index.php" class="btn btn-outline-primary w-100 py-3">
      <i class="bi bi-people fs-3 d-block mb-2"></i> Kelola Contact
    </a>
  </div>
  <div class="col-md-3">
    <a href="<?= BASE_URL ?>/groups/index.php" class="btn btn-outline-success w-100 py-3">
      <i class="bi bi-collection fs-3 d-block mb-2"></i> Kelola Group
    </a>
  </div>
  <div class="col-md-3">
    <a href="<?= BASE_URL ?>/assignments/index.php" class="btn btn-outline-warning w-100 py-3">
      <i class="bi bi-diagram-3 fs-3 d-block mb-2"></i> Assign Contact
    </a>
  </div>
  <div class="col-md-3">
    <a href="<?= BASE_URL ?>/reports/index.php" class="btn btn-outline-info w-100 py-3">
      <i class="bi bi-bar-chart fs-3 d-block mb-2"></i> Laporan
    </a>
  </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
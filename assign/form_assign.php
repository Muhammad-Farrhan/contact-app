<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$contactId = $_GET['contact_id'] ?? '';

$contacts = $pdo->query("SELECT contact_id, title, name FROM contacts ORDER BY name")->fetchAll();
$groups   = $pdo->query("SELECT group_id, group_name, priority FROM group_master ORDER BY group_name")->fetchAll();

// Group yang sudah dimiliki contact terpilih
$ownedGroups = [];
if ($contactId !== '') {
    $stmt = $pdo->prepare("SELECT group_id FROM contact_group_membership WHERE contact_id = :cid");
    $stmt->execute([':cid' => $contactId]);
    $ownedGroups = array_column($stmt->fetchAll(), 'group_id');
}
?>

<h3>Assign Contact ke Group</h3>

<form action="save_assign.php" method="POST">
  <div class="mb-3">
    <label class="form-label">Contact <span class="text-danger">*</span></label>
    <select name="contact_id" class="form-select" required
            onchange="location.href='form_assign.php?contact_id='+this.value">
      <option value="">-- Pilih Contact --</option>
      <?php foreach ($contacts as $c): ?>
        <option value="<?= $c['contact_id'] ?>" <?= $contactId == $c['contact_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['title'].' '.$c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Group (boleh pilih lebih dari satu)</label>
    <div class="row">
      <?php foreach ($groups as $g): ?>
        <div class="col-md-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox"
                   name="group_ids[]" value="<?= $g['group_id'] ?>"
                   id="g<?= $g['group_id'] ?>"
                   <?= in_array($g['group_id'], $ownedGroups) ? 'checked' : '' ?>>
            <label class="form-check-label" for="g<?= $g['group_id'] ?>">
              <?= htmlspecialchars($g['group_name']) ?>
              <span class="badge bg-<?= $g['priority']==='high' ? 'danger' : ($g['priority']==='med' ? 'warning' : 'secondary') ?>">
                <?= $g['priority'] ?>
              </span>
            </label>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
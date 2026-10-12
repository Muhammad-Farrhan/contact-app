<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM contacts WHERE contact_id = ?");
$stmt->execute([$id]);
$contact = $stmt->fetch();

if (!$contact) {
    setFlash('error', 'Contact tidak ditemukan.');
    redirect('/contacts/index.php');
}

$stmt = $pdo->prepare("SELECT * FROM contact_phones WHERE contact_id = ? ORDER BY is_primary DESC, phone_id");
$stmt->execute([$id]);
$phones = $stmt->fetchAll();

$pageTitle = 'Edit Contact';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Contact</a></li>
    <li class="breadcrumb-item active">Edit</li>
  </ol>
</nav>

<h3 class="mb-3"><i class="bi bi-pencil-square"></i> Edit Contact</h3>

<form action="save.php" method="POST" class="card p-4">
  <input type="hidden" name="contact_id" value="<?= $contact['contact_id'] ?>">

  <div class="mb-3">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" required maxlength="150"
           value="<?= e($contact['name']) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Title <span class="text-danger">*</span></label>
    <select name="title" class="form-select" required>
      <?php foreach (['Mr','Mrs','Ms'] as $t): ?>
        <option <?= $contact['title']===$t?'selected':'' ?>><?= $t ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">No Telp</label>
    <div id="phone-list">
      <?php foreach ($phones as $ph): ?>
      <div class="input-group mb-2">
        <input type="text" name="phone_number[]" class="form-control" value="<?= e($ph['phone_number']) ?>">
        <select name="phone_type[]" class="form-select" style="max-width:140px">
          <?php foreach (['Mobile','Office','Fax','WhatsApp','Other'] as $pt): ?>
            <option <?= $ph['phone_type']===$pt?'selected':'' ?>><?= $pt ?></option>
          <?php endforeach; ?>
        </select>
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
          <i class="bi bi-x"></i>
        </button>
      </div>
      <?php endforeach; ?>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPhone()">
      <i class="bi bi-plus"></i> Tambah No Telp
    </button>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<script>
function addPhone() {
  const w = document.getElementById('phone-list');
  const d = document.createElement('div');
  d.className = 'input-group mb-2';
  d.innerHTML = `
    <input type="text" name="phone_number[]" class="form-control">
    <select name="phone_type[]" class="form-select" style="max-width:140px">
      <option>Mobile</option><option>Office</option><option>Fax</option>
      <option>WhatsApp</option><option>Other</option>
    </select>
    <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
      <i class="bi bi-x"></i>
    </button>`;
  w.appendChild(d);
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php
require_once __DIR__ . '/../includes/header.php';
$pageTitle = 'Tambah Contact';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index.php">Contact</a></li>
    <li class="breadcrumb-item active">Tambah</li>
  </ol>
</nav>

<h3 class="mb-3"><i class="bi bi-person-plus"></i> Tambah Contact</h3>

<form action="save.php" method="POST" class="card p-4">
  <div class="mb-3">
    <label class="form-label">Name <span class="text-danger">*</span></label>
    <input type="text" name="name" class="form-control" required maxlength="150"
           placeholder="Contoh: Muhammad Farhan">
  </div>

  <div class="mb-3">
    <label class="form-label">Title <span class="text-danger">*</span></label>
    <select name="title" class="form-select" required>
      <option value="">-- Pilih --</option>
      <option>Mr</option><option>Mrs</option><option>Ms</option>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">No Telp</label>
    <div id="phone-list">
      <div class="input-group mb-2">
        <input type="text" name="phone_number[]" class="form-control" placeholder="Contoh: 0852-1069-8869">
        <select name="phone_type[]" class="form-select" style="max-width:140px">
          <option>Mobile</option><option>Office</option><option>Fax</option>
          <option>WhatsApp</option><option>Other</option>
        </select>
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
          <i class="bi bi-x"></i>
        </button>
      </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addPhone()">
      <i class="bi bi-plus"></i> Tambah No Telp
    </button>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
  </div>
</form>

<script>
function addPhone() {
  const w = document.getElementById('phone-list');
  const d = document.createElement('div');
  d.className = 'input-group mb-2';
  d.innerHTML = `
    <input type="text" name="phone_number[]" class="form-control" placeholder="Contoh: 0852-1069-8869">
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
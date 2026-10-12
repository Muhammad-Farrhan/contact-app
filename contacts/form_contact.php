<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/header.php';

$edit   = false;
$data   = ['contact_id' => '', 'name' => '', 'title' => ''];
$phones = [];

if (isset($_GET['id'])) {
    $edit = true;
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE contact_id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $data = $stmt->fetch();

    $stmtP = $pdo->prepare("SELECT * FROM contact_phones WHERE contact_id = :id ORDER BY is_primary DESC, phone_id");
    $stmtP->execute([':id' => $_GET['id']]);
    $phones = $stmtP->fetchAll();
}
?>

<h3><?= $edit ? 'Edit' : 'Tambah' ?> Contact</h3>

<form action="save_contact.php" method="POST">
    <input type="hidden" name="contact_id" value="<?= htmlspecialchars($data['contact_id']) ?>">

    <div class="mb-3">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" required maxlength="150"
               value="<?= htmlspecialchars($data['name']) ?>"
               placeholder="Contoh: Muhammad Farhan">
    </div>

    <div class="mb-3">
        <label class="form-label">Title <span class="text-danger">*</span></label>
        <select name="title" class="form-select" required>
            <option value="">-- Pilih Title --</option>
            <?php foreach (['Mr','Mrs','Ms'] as $t): ?>
                <option value="<?= $t ?>" <?= $data['title'] === $t ? 'selected' : '' ?>><?= $t ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">No Telp</label>
        <div id="phone-list">
            <?php if (!empty($phones)): ?>
                <?php foreach ($phones as $ph): ?>
                    <div class="input-group mb-2">
                        <input type="hidden" name="phone_id[]" value="<?= $ph['phone_id'] ?>">
                        <input type="text" name="phone_number[]" class="form-control"
                               value="<?= htmlspecialchars($ph['phone_number']) ?>"
                               placeholder="Contoh: 0852-1069-8869">
                        <select name="phone_type[]" class="form-select" style="max-width:150px">
                            <?php foreach (['Mobile','Office','Fax','WhatsApp','Other'] as $pt): ?>
                                <option value="<?= $pt ?>" <?= $ph['phone_type'] === $pt ? 'selected' : '' ?>><?= $pt ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Hapus</button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="input-group mb-2">
                    <input type="text" name="phone_number[]" class="form-control" placeholder="Contoh: 0852-1069-8869">
                    <select name="phone_type[]" class="form-select" style="max-width:150px">
                        <option value="Mobile">Mobile</option>
                        <option value="Office">Office</option>
                        <option value="Fax">Fax</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="Other">Other</option>
                    </select>
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Hapus</button>
                </div>
            <?php endif; ?>
        </div>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addPhone()">
            <i class="bi bi-plus-circle"></i> Tambah No Telp
        </button>
    </div>

    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
    <a href="list_contact.php" class="btn btn-secondary">Batal</a>
</form>

<script>
function addPhone() {
    const wrap = document.getElementById('phone-list');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="phone_number[]" class="form-control" placeholder="Contoh: 0852-1069-8869">
        <select name="phone_type[]" class="form-select" style="max-width:150px">
            <option value="Mobile">Mobile</option>
            <option value="Office">Office</option>
            <option value="Fax">Fax</option>
            <option value="WhatsApp">WhatsApp</option>
            <option value="Other">Other</option>
        </select>
        <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Hapus</button>`;
    wrap.appendChild(div);
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
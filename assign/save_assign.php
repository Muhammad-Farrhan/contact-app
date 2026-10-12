<?php
require_once __DIR__ . '/../config/database.php';

$contactId = $_POST['contact_id'] ?? '';
$groupIds  = $_POST['group_ids'] ?? [];

if ($contactId === '') {
    die("Contact wajib dipilih.");
}

try {
    $pdo->beginTransaction();

    // Hapus assignment lama, ganti dengan yang baru
    $pdo->prepare("DELETE FROM contact_group_membership WHERE contact_id = :cid")
        ->execute([':cid' => $contactId]);

    // Insert assignment baru
    if (!empty($groupIds)) {
        $stmt = $pdo->prepare("INSERT INTO contact_group_membership (contact_id, group_id)
                               VALUES (:cid, :gid)");
        foreach ($groupIds as $gid) {
            $stmt->execute([':cid' => $contactId, ':gid' => $gid]);
        }
    }

    $pdo->commit();
    header("Location: form_assign.php?contact_id=$contactId&msg=success");
} catch (Exception $e) {
    $pdo->rollBack();
    die("Gagal assign: " . $e->getMessage());
}
<?php
require_once __DIR__ . '/../includes/header.php';

$contact_id = (int)($_POST['contact_id'] ?? 0);
$group_ids  = $_POST['group_ids'] ?? [];

if (!$contact_id) {
    setFlash('error', 'Contact tidak valid.');
    redirect('/assignments/index.php');
}

try {
    $pdo->beginTransaction();
    $pdo->prepare("DELETE FROM contact_group_membership WHERE contact_id = ?")->execute([$contact_id]);

    if (!empty($group_ids)) {
        $ins = $pdo->prepare("INSERT INTO contact_group_membership (contact_id, group_id) VALUES (?, ?)");
        foreach ($group_ids as $gid) {
            $ins->execute([$contact_id, (int)$gid]);
        }
    }

    $pdo->commit();
    setFlash('success', 'Assignment berhasil disimpan.');
} catch (Exception $ex) {
    $pdo->rollBack();
    setFlash('error', 'Gagal simpan: ' . $ex->getMessage());
}

redirect('/assignments/index.php');
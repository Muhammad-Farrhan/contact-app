<?php
require_once __DIR__ . '/../includes/header.php';

$id     = $_POST['contact_id'] ?? '';
$name   = trim($_POST['name'] ?? '');
$title  = $_POST['title'] ?? '';

if ($name === '' || !in_array($title, ['Mr','Mrs','Ms'])) {
    setFlash('error', 'Data tidak lengkap.');
    redirect('/contacts/index.php');
}

try {
    $pdo->beginTransaction();

    if ($id === '') {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, title) VALUES (?, ?)");
        $stmt->execute([$name, $title]);
        $id = $pdo->lastInsertId();
        $msg = 'Contact berhasil ditambahkan.';
    } else {
        $stmt = $pdo->prepare("UPDATE contacts SET name = ?, title = ? WHERE contact_id = ?");
        $stmt->execute([$name, $title, $id]);
        $pdo->prepare("DELETE FROM contact_phones WHERE contact_id = ?")->execute([$id]);
        $msg = 'Contact berhasil diupdate.';
    }

    $ins = $pdo->prepare("INSERT INTO contact_phones (contact_id, phone_number, phone_type, is_primary)
                          VALUES (?, ?, ?, ?)");
    $first = true;
    foreach (($_POST['phone_number'] ?? []) as $i => $phone) {
        $phone = trim($phone);
        if ($phone === '') continue;
        $ins->execute([$id, $phone, $_POST['phone_type'][$i] ?? 'Mobile', $first ? 1 : 0]);
        $first = false;
    }

    $pdo->commit();
    setFlash('success', $msg);
} catch (Exception $ex) {
    $pdo->rollBack();
    setFlash('error', 'Gagal simpan: ' . $ex->getMessage());
}

redirect('/contacts/index.php');
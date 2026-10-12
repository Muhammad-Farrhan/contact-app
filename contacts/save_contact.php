<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo->beginTransaction();

    $contactId = $_POST['contact_id'] ?? '';

    if ($contactId === '') {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, title) VALUES (:name, :title)");
        $stmt->execute([
            ':name'  => $_POST['name'],
            ':title' => $_POST['title'],
        ]);
        $contactId = $pdo->lastInsertId();
    } else {
        $stmt = $pdo->prepare("UPDATE contacts SET name = :name, title = :title
                               WHERE contact_id = :id");
        $stmt->execute([
            ':name'  => $_POST['name'],
            ':title' => $_POST['title'],
            ':id'    => $contactId,
        ]);
        $pdo->prepare("DELETE FROM contact_phones WHERE contact_id = :id")
            ->execute([':id' => $contactId]);
    }

    $stmtPhone = $pdo->prepare("INSERT INTO contact_phones
        (contact_id, phone_number, phone_type, is_primary)
        VALUES (:cid, :phone, :type, :primary)");

    $first = true;
    foreach (($_POST['phone_number'] ?? []) as $i => $phone) {
        if (trim($phone) === '') continue;
        $stmtPhone->execute([
            ':cid'     => $contactId,
            ':phone'   => trim($phone),
            ':type'    => $_POST['phone_type'][$i] ?? 'Mobile',
            ':primary' => $first ? 1 : 0,
        ]);
        $first = false;
    }

    $pdo->commit();
    header('Location: list_contact.php?msg=' . ($_POST['contact_id'] === '' ? 'created' : 'updated'));
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    die("Gagal simpan: " . $e->getMessage());
}
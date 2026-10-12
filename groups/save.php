<?php
require_once __DIR__ . '/../includes/header.php';

$id         = $_POST['group_id'] ?? '';
$group_name = trim($_POST['group_name'] ?? '');
$priority   = $_POST['priority'] ?? '';

if ($group_name === '' || !in_array($priority, ['low','med','high'])) {
    setFlash('error', 'Data tidak lengkap.');
    redirect('/groups/index.php');
}

try {
    if ($id === '') {
        $stmt = $pdo->prepare("INSERT INTO group_master (group_name, priority) VALUES (?, ?)");
        $stmt->execute([$group_name, $priority]);
        setFlash('success', 'Group berhasil ditambahkan.');
    } else {
        $stmt = $pdo->prepare("UPDATE group_master SET group_name = ?, priority = ? WHERE group_id = ?");
        $stmt->execute([$group_name, $priority, $id]);
        setFlash('success', 'Group berhasil diupdate.');
    }
} catch (PDOException $ex) {
    setFlash('error', 'Gagal simpan: ' . $ex->getMessage());
}

redirect('/groups/index.php');
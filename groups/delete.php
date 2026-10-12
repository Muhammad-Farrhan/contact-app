<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM group_master WHERE group_id = ?")->execute([$id]);
    setFlash('success', 'Group berhasil dihapus.');
}
redirect('/groups/index.php');
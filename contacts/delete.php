<?php
require_once __DIR__ . '/../includes/header.php';

$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $pdo->prepare("DELETE FROM contacts WHERE contact_id = ?")->execute([$id]);
    setFlash('success', 'Contact berhasil dihapus.');
}
redirect('/contacts/index.php');
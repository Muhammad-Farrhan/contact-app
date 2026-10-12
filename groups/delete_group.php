<?php
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? '';
if ($id !== '') {
    $pdo->prepare("DELETE FROM group_master WHERE group_id = :id")
        ->execute([':id' => $id]);
}
header('Location: list_group.php?msg=deleted');
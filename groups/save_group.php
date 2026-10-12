<?php
require_once __DIR__ . '/../config/database.php';

$group_id = $_POST['group_id'] ?? '';

if ($group_id === '') {
    $stmt = $pdo->prepare("INSERT INTO group_master (group_name, priority)
                           VALUES (:name, :priority)");
    $stmt->execute([
        ':name'     => $_POST['group_name'],
        ':priority' => $_POST['priority'],
    ]);
    $msg = 'created';
} else {
    $stmt = $pdo->prepare("UPDATE group_master
                           SET group_name = :name, priority = :priority
                           WHERE group_id = :id");
    $stmt->execute([
        ':name'     => $_POST['group_name'],
        ':priority' => $_POST['priority'],
        ':id'       => $group_id,
    ]);
    $msg = 'updated';
}

header("Location: list_group.php?msg=$msg");
<?php
require_once __DIR__ . '/../config/database.php';

$id = $_GET['id'] ?? '';
if ($id !== '') {
    $pdo->prepare("DELETE FROM contacts WHERE contact_id = :id")
        ->execute([':id' => $id]);
}
header('Location: list_contact.php?msg=deleted');
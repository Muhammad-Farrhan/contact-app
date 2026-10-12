<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/helpers.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Contact Manager' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/index.php">
      <i class="bi bi-journal-bookmark-fill"></i> Contact Manager
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?= isActive('contacts') ?>" href="<?= BASE_URL ?>/contacts/index.php">
            <i class="bi bi-people"></i> Contacts
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isActive('groups') ?>" href="<?= BASE_URL ?>/groups/index.php">
            <i class="bi bi-collection"></i> Groups
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isActive('assignments') ?>" href="<?= BASE_URL ?>/assignments/index.php">
            <i class="bi bi-diagram-3"></i> Assignments
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= isActive('reports') ?>" href="<?= BASE_URL ?>/reports/index.php">
            <i class="bi bi-bar-chart"></i> Reports
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">
<?php showFlash(); ?>
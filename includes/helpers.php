<?php

function redirect($path) {
    header("Location: " . BASE_URL . $path);
    exit;
}

function setFlash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function showFlash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        $cls = $f['type'] === 'error' ? 'danger' : $f['type'];
        echo "<div class='alert alert-{$cls} alert-dismissible fade show'>
                {$f['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION['flash']);
    }
}

function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function isActive($folder) {
    return strpos($_SERVER['REQUEST_URI'], "/$folder/") !== false ? 'active' : '';
}
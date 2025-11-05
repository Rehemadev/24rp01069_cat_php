<?php
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

function is_logged_in(): bool {
    return isset($_SESSION['user']);
}

function is_admin(): bool {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

function require_admin(): void {
    if (!is_admin()) {
        header('Location: dashboard.php');
        exit;
    }
}
?>

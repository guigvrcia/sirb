<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

function auth_user(): ?array {
    return $_SESSION['user'] ?? null;
}

function require_login(): void {
    if (!auth_user()) {
        flash_set('warning', 'Faça login para acessar esta área.');
        redirect(BASE_URL . '/login.php');
    }
}

function require_admin(): void {
    require_login();
    $u = auth_user();
    if (($u['perfil'] ?? '') !== 'admin') {
        flash_set('danger', 'Acesso restrito ao administrador.');
        redirect(BASE_URL . '/private/dashboard.php');
    }
}
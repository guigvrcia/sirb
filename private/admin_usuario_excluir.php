<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    flash_set('danger', 'ID inválido.');
    redirect(BASE_URL . '/private/admin_usuarios.php');
}

// não deixa o admin excluir a si mesmo
if ($id === (int)auth_user()['id']) {
    flash_set('warning', 'Você não pode excluir sua própria conta admin por aqui.');
    redirect(BASE_URL . '/private/admin_usuarios.php');
}

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
$stmt->execute([$id]);

flash_set('success', 'Usuário excluído.');
redirect(BASE_URL . '/private/admin_usuarios.php');
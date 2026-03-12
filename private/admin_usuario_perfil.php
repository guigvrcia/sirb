<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$perfil = $_GET['perfil'] ?? '';

// mudança: 'admin' no lugar de 'administrador' p corresponder o banco
$permitidos = ['cliente', 'barbeiro', 'admin'];

if ($id && in_array($perfil, $permitidos)) {
    $stmt = $pdo->prepare("UPDATE usuarios SET perfil = ? WHERE id = ?");
    $stmt->execute([$perfil, $id]);
    flash_set('success', 'Perfil atualizado.');
}

redirect(BASE_URL . '/private/admin_usuarios.php');
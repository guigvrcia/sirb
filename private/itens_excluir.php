<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();
$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    flash_set('danger', 'ID inválido.');
    redirect(BASE_URL . '/private/itens_listar.php');
}

$stmt = $pdo->prepare("DELETE FROM itens WHERE id=?");
$stmt->execute([$id]);

flash_set('success', 'Item excluído.');
redirect(BASE_URL . '/private/itens_listar.php');
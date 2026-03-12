<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

if (!is_post()) {
    redirect(BASE_URL . '/private/itens_listar.php');
}

$pdo = db();

$id = (int)($_POST['id'] ?? 0);
$nome = trim($_POST['nome'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$preco = (float)($_POST['preco'] ?? 0);
$ativo = isset($_POST['ativo']) ? 1 : 0;

if ($nome === '' || $preco < 0) {
    flash_set('danger', 'Dados inválidos.');
    redirect(BASE_URL . '/private/itens_listar.php');
}

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE itens SET nome=?, descricao=?, preco=?, ativo=? WHERE id=?");
    $stmt->execute([$nome, $descricao, $preco, $ativo, $id]);
    flash_set('success', 'Item atualizado.');
} else {
    $stmt = $pdo->prepare("INSERT INTO itens (nome, descricao, preco, ativo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $ativo]);
    flash_set('success', 'Item cadastrado.');
}

redirect(BASE_URL . '/private/itens_listar.php');
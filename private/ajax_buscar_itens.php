<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

header('Content-Type: application/json; charset=utf-8');

$q = trim($_GET['q'] ?? '');
if ($q === '' || strlen($q) < 2) {
    echo json_encode(['ok' => true, 'data' => []]);
    exit;
}

$pdo = db();
$stmt = $pdo->prepare("SELECT id, nome, preco FROM itens WHERE nome LIKE ? ORDER BY id DESC LIMIT 10");
$stmt->execute(['%' . $q . '%']);

echo json_encode(['ok' => true, 'data' => $stmt->fetchAll()]);
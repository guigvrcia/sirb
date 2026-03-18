<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

header('Content-Type: application/json; charset=utf-8');

$pdo = db();

$q = trim($_GET['q'] ?? '');

if ($q === '') {
    echo json_encode([
        'ok' => true,
        'data' => []
    ]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT id, nome, preco
    FROM itens
    WHERE nome LIKE ?
    ORDER BY nome
    LIMIT 10
");

$stmt->execute(['%' . $q . '%']);

$itens = $stmt->fetchAll();

echo json_encode([
    'ok' => true,
    'data' => $itens
]);
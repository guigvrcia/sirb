<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$pdo = db();
$user = auth_user();

$item_id = (int)($_POST['item_id'] ?? 0);
$barbeiro_id = (int)($_POST['barbeiro_id'] ?? 0);
$data = $_POST['data'] ?? '';
$hora = $_POST['hora'] ?? '';

if (!$item_id || !$barbeiro_id || !$data || !$hora) {
    flash_set('danger', 'Preencha todos os campos.');
    redirect(BASE_URL . '/private/agendar.php');
}

$hora = substr($hora, 0, 5);
$data_hora = $data . ' ' . $hora;

if (strtotime($data_hora) < time()) {
    flash_set('danger', 'Não é possível agendar no passado.');
    redirect(BASE_URL . '/private/agendar.php');
}

$stmt = $pdo->prepare("
    INSERT INTO agendamentos (usuario_id, item_id, barbeiro_id, data, hora)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->execute([
    $user['id'],
    $item_id,
    $barbeiro_id,
    $data,
    $hora . ':00'
]);

flash_set('success', 'Agendamento realizado com sucesso.');
redirect(BASE_URL . '/private/dashboard.php');
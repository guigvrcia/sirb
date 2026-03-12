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
    SELECT id
    FROM horarios_bloqueados
    WHERE barbeiro_id = ? AND data = ? AND hora = ?
");
$stmt->execute([$barbeiro_id, $data, $hora . ':00']);
if ($stmt->fetch()) {
    flash_set('danger', 'Este horário está bloqueado para este barbeiro.');
    redirect(BASE_URL . '/private/agendar.php');
}

$stmt = $pdo->prepare("
    SELECT id
    FROM agendamentos
    WHERE barbeiro_id = ? AND data = ? AND hora = ? AND status = 'agendado'
");
$stmt->execute([$barbeiro_id, $data, $hora . ':00']);
if ($stmt->fetch()) {
    flash_set('danger', 'Este horário já está ocupado para este barbeiro.');
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
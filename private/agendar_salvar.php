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

// VALIDAÇÃO ADICIONAL: não permitir agendamento no passado
$data_hora = $data . ' ' . $hora;
if (strtotime($data_hora) < strtotime(date('Y-m-d H:i'))) {
    flash_set('danger', 'Não é possível agendar no passado.');
    redirect(BASE_URL . '/private/agendar.php');
}

// VALIDAÇÃO ADICIONAL: verificar se horário já está ocupado
$stmt = $pdo->prepare("
    SELECT id FROM agendamentos 
    WHERE barbeiro_id = ? AND data = ? AND hora = ? AND status = 'agendado'
");
$stmt->execute([$barbeiro_id, $data, $hora]);
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
    $hora
]);

flash_set('success', 'Agendamento realizado com sucesso.');
redirect(BASE_URL . '/private/dashboard.php');
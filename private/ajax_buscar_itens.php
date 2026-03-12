<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

header('Content-Type: application/json; charset=utf-8');

$pdo = db();

$data = $_GET['data'] ?? '';
$barbeiro_id = (int)($_GET['barbeiro_id'] ?? 0);

if (!$data || !$barbeiro_id) {
    echo json_encode([]);
    exit;
}

$hoje = date('Y-m-d');
$agora = date('H:i');

$horariosBase = [
    '08:00', '09:00', '10:00', '11:00',
    '13:00', '14:00', '15:00', '16:00', '17:00'
];

$stmt = $pdo->prepare("
    SELECT TIME_FORMAT(hora, '%H:%i') AS hora
    FROM agendamentos
    WHERE barbeiro_id = ?
      AND data = ?
      AND status = 'agendado'
");
$stmt->execute([$barbeiro_id, $data]);
$ocupados = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->prepare("
    SELECT TIME_FORMAT(hora, '%H:%i') AS hora
    FROM horarios_bloqueados
    WHERE barbeiro_id = ?
      AND data = ?
");
$stmt->execute([$barbeiro_id, $data]);
$bloqueados = $stmt->fetchAll(PDO::FETCH_COLUMN);

$indisponiveis = array_merge($ocupados, $bloqueados);

$disponiveis = array_values(array_filter($horariosBase, function ($h) use ($data, $hoje, $agora, $indisponiveis) {
    if (in_array($h, $indisponiveis, true)) {
        return false;
    }

    if ($data === $hoje && $h <= $agora) {
        return false;
    }

    return true;
}));

echo json_encode($disponiveis);
<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$pdo = db();
$user = auth_user();

$id = (int)($_GET['id'] ?? 0);

if ($id) {

$stmt = $pdo->prepare("
UPDATE agendamentos
SET status='cancelado'
WHERE id=? AND usuario_id=?
");

$stmt->execute([$id,$user['id']]);

flash_set('success','Agendamento cancelado.');

}

redirect(BASE_URL.'/private/meus_agendamentos.php');
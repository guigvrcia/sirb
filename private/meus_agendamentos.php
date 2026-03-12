<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$pdo = db();
$user = auth_user();

$stmt = $pdo->prepare("
SELECT 
a.id,
a.data,
a.hora,
a.status,
i.nome AS servico,
u.nome AS barbeiro

FROM agendamentos a

JOIN itens i ON i.id = a.item_id
JOIN barbeiros b ON b.id = a.barbeiro_id
JOIN usuarios u ON u.id = b.usuario_id

WHERE a.usuario_id = ?

ORDER BY a.data DESC, a.hora DESC
");

$stmt->execute([$user['id']]);
$agendamentos = $stmt->fetchAll();

require_once __DIR__ . '/../app/header.php';
?>

<h1 class="h4 mb-4">Meus Agendamentos</h1>

<div class="mb-3">
<a class="btn btn-outline-primary btn-sm"
href="<?= h(BASE_URL) ?>/private/agendar.php">

Novo agendamento

</a>

<a class="btn btn-outline-secondary btn-sm"
href="<?= h(BASE_URL) ?>/private/dashboard.php">

Voltar

</a>
</div>

<div class="table-responsive">

<table class="table table-striped align-middle">

<thead>
<tr>
<th>Serviço</th>
<th>Barbeiro</th>
<th>Data</th>
<th>Hora</th>
<th>Status</th>
<th class="text-end">Ação</th>
</tr>
</thead>

<tbody>

<?php foreach ($agendamentos as $a): ?>

<tr>

<td><?= h($a['servico']) ?></td>

<td><?= h($a['barbeiro']) ?></td>

<td><?= date('d/m/Y', strtotime($a['data'])) ?></td>

<td><?= substr($a['hora'],0,5) ?></td>

<td>
<?php if ($a['status'] === 'agendado'): ?>
<span class="badge bg-primary">Agendado</span>
<?php elseif ($a['status'] === 'cancelado'): ?>
<span class="badge bg-danger">Cancelado</span>
<?php else: ?>
<span class="badge bg-success">Finalizado</span>
<?php endif; ?>
</td>

<td class="text-end">

<?php if ($a['status'] === 'agendado'): ?>

<a class="btn btn-outline-danger btn-sm"
href="<?= h(BASE_URL) ?>/private/agendamento_cancelar.php?id=<?= $a['id'] ?>">

Cancelar

</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
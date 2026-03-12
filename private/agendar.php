<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$pdo = db();

$servicos = $pdo->query("SELECT * FROM itens WHERE ativo=1 ORDER BY nome")->fetchAll();

$barbeiros = $pdo->query("
SELECT b.id, u.nome
FROM barbeiros b
JOIN usuarios u ON u.id = b.usuario_id
WHERE b.ativo = 1
")->fetchAll();

require_once __DIR__ . '/../app/header.php';
?>

<h1 class="h4 mb-4">Agendar serviço</h1>

<form method="post" action="<?= h(BASE_URL) ?>/private/agendar_salvar.php" class="row g-3">

<div class="col-md-6">
<label class="form-label">Serviço</label>
<select name="item_id" class="form-select" required>
<option value="">Selecione</option>
<?php foreach ($servicos as $s): ?>
<option value="<?= $s['id'] ?>">
<?= h($s['nome']) ?> (R$ <?= number_format($s['preco'],2,',','.') ?>)
</option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Barbeiro</label>
<select name="barbeiro_id" class="form-select" required>
<option value="">Selecione</option>
<?php foreach ($barbeiros as $b): ?>
<option value="<?= $b['id'] ?>">
<?= h($b['nome']) ?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="col-md-6">
<label class="form-label">Data</label>
<input type="date" name="data" class="form-control" required>
</div>

<div class="col-md-6">
<label class="form-label">Hora</label>
<input type="time" name="hora" class="form-control" required>
</div>

<div class="col-12">
<button class="btn btn-primary">Agendar</button>
<a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/private/dashboard.php">Voltar</a>
</div>

</form>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
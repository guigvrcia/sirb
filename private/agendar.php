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
<select name="barbeiro_id" id="barbeiro_id" class="form-select" required>
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
    <input type="date" name="data" id="data" class="form-control" min="<?= date('Y-m-d') ?>" required>
</div>

<div class="col-md-6">
    <label class="form-label">Horário</label>
    <select name="hora" id="hora" class="form-select" required>
        <option value="">Selecione</option>
        <option value="08:00">08:00</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="13:00">13:00</option>
        <option value="14:00">14:00</option>
        <option value="15:00">15:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
    </select>
</div>

<div class="col-12">
<button class="btn btn-primary">Agendar</button>
<a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/private/dashboard.php">Voltar</a>
</div>

</form>

<script>
const dataInput = document.getElementById('data');
const barbeiroSelect = document.getElementById('barbeiro_id');
const horaSelect = document.getElementById('hora');


dataInput.addEventListener('change', carregarHorarios);
barbeiroSelect.addEventListener('change', carregarHorarios);
</script>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
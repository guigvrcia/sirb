<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$pdo = db();

$busca = trim($_GET['q'] ?? '');
if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM itens WHERE nome LIKE ? ORDER BY id DESC");
    $stmt->execute(['%' . $busca . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM itens ORDER BY id DESC");
}
$itens = $stmt->fetchAll();

require_once __DIR__ . '/../app/header.php';
?>
<h1 class="h4">Itens (Serviços)</h1>

<div class="d-flex gap-2 mb-3">
  <a class="btn btn-success btn-sm" href="<?= h(BASE_URL) ?>/private/itens_form.php">Novo item</a>
  <a class="btn btn-outline-secondary btn-sm" href="<?= h(BASE_URL) ?>/private/dashboard.php">Voltar</a>
</div>

<form class="row g-2 mb-3" method="get">
  <div class="col-md-8">
    <input class="form-control" name="q" placeholder="Buscar por nome..." value="<?= h($busca) ?>">
  </div>
  <div class="col-md-4 d-grid">
    <button class="btn btn-outline-primary">Buscar</button>
  </div>
</form>

<!-- Extra (AJAX): busca assíncrona -->
<div class="mb-3">
  <label class="form-label">Busca rápida (AJAX)</label>
  <input id="ajaxSearch" class="form-control" placeholder="Digite para buscar...">
  <div id="ajaxResults" class="mt-2 small text-muted"></div>
</div>

<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Preço</th>
      <th>Ativo</th>
      <th class="text-end">Ações</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($itens as $i): ?>
    <tr>
      <td><?= (int)$i['id'] ?></td>
      <td><?= h($i['nome']) ?></td>
      <td>R$ <?= number_format((float)$i['preco'], 2, ',', '.') ?></td>
      <td><?= $i['ativo'] ? 'Sim' : 'Não' ?></td>
      <td class="text-end">
        <a class="btn btn-outline-primary btn-sm" href="<?= h(BASE_URL) ?>/private/itens_form.php?id=<?= (int)$i['id'] ?>">Editar</a>
        <a class="btn btn-outline-danger btn-sm" href="<?= h(BASE_URL) ?>/private/itens_excluir.php?id=<?= (int)$i['id'] ?>">Excluir</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
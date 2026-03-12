<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();

$id = (int)($_GET['id'] ?? 0);
$nome = '';
$descricao = '';
$preco = '0.00';
$ativo = 1;

if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM itens WHERE id=?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    if ($item) {
        $nome = $item['nome'];
        $descricao = $item['descricao'] ?? '';
        $preco = $item['preco'];
        $ativo = (int)$item['ativo'];
    } else {
        flash_set('danger', 'Item não encontrado.');
        redirect(BASE_URL . '/private/itens_listar.php');
    }
}

require_once __DIR__ . '/../app/header.php';
?>
<h1 class="h4"><?= $id ? 'Editar' : 'Novo' ?> item</h1>

<form method="post" action="<?= h(BASE_URL) ?>/private/itens_salvar.php" class="row g-3 needs-validation" novalidate>
  <input type="hidden" name="id" value="<?= (int)$id ?>">

  <div class="col-md-6">
    <label class="form-label">Nome</label>
    <input name="nome" class="form-control" value="<?= h($nome) ?>" required>
    <div class="invalid-feedback">Informe o nome.</div>
  </div>

  <div class="col-md-6">
    <label class="form-label">Preço (R$)</label>
    <input name="preco" type="number" step="0.01" min="0" class="form-control" value="<?= h((string)$preco) ?>" required>
    <div class="invalid-feedback">Informe um preço válido.</div>
  </div>

  <div class="col-12">
    <label class="form-label">Descrição</label>
    <textarea name="descricao" class="form-control" rows="3"><?= h($descricao) ?></textarea>
  </div>

  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo" <?= $ativo ? 'checked' : '' ?>>
      <label class="form-check-label" for="ativo">Ativo</label>
    </div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Salvar</button>
    <a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/private/itens_listar.php">Voltar</a>
  </div>
</form>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
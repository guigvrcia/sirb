<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();

$users = $pdo->query("
SELECT id, nome, email, perfil, criado_em
FROM usuarios
ORDER BY id DESC
")->fetchAll();

require_once __DIR__ . '/../app/header.php';
?>

<h1 class="h4">Administrador — Usuários</h1>

<div class="d-flex gap-2 mb-3">
  <a class="btn btn-outline-secondary btn-sm"
  href="<?= h(BASE_URL) ?>/private/dashboard.php">
  Voltar
  </a>

  <a class="btn btn-success btn-sm"
  href="<?= h(BASE_URL) ?>/private/admin_barbeiro_novo.php">
  Cadastrar barbeiro
  </a>
</div>

<div class="table-responsive">

<table class="table table-striped align-middle">

<thead>
<tr>
<th>ID</th>
<th>Nome</th>
<th>E-mail</th>
<th>Perfil</th>
<th>Criado em</th>
<th class="text-end">Ações</th>
</tr>
</thead>

<tbody>

<?php foreach ($users as $u): ?>

<tr>

<td><?= (int)$u['id'] ?></td>
<td><?= h($u['nome']) ?></td>
<td><?= h($u['email']) ?></td>
<td>
<?php
if ($u['perfil'] === 'admin') {
    echo 'Administrador';
} elseif ($u['perfil'] === 'barbeiro') {
    echo 'Barbeiro';
} else {
    echo 'Cliente';
}
?>
</td>

<td><?= h($u['criado_em']) ?></td>

<td class="text-end">

<a class="btn btn-outline-primary btn-sm"
href="<?= h(BASE_URL) ?>/private/admin_usuario_perfil.php?id=<?= (int)$u['id'] ?>&perfil=cliente">
Cliente
</a>

<a class="btn btn-outline-success btn-sm"
href="<?= h(BASE_URL) ?>/private/admin_usuario_perfil.php?id=<?= (int)$u['id'] ?>&perfil=barbeiro">
Barbeiro
</a>

<a class="btn btn-outline-warning btn-sm"
href="<?= h(BASE_URL) ?>/private/admin_usuario_perfil.php?id=<?= (int)$u['id'] ?>&perfil=admin">
Administrador
</a>

<a class="btn btn-outline-danger btn-sm"
href="<?= h(BASE_URL) ?>/private/admin_usuario_excluir.php?id=<?= (int)$u['id'] ?>"
onclick="return confirm('Excluir este usuário?');">
Excluir
</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
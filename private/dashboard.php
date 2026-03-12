<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

require_once __DIR__ . '/../app/header.php';
$u = auth_user();
?>

<h1 class="h4">Área Privada</h1>

<p>
Olá, <strong><?= h($u['nome']) ?></strong>
(perfil:
<?php
if ($u['perfil'] === 'admin') {
    echo 'Administrador';
} elseif ($u['perfil'] === 'barbeiro') {
    echo 'Barbeiro';
} else {
    echo 'Cliente';
}
?>
)
</p>

<div class="row g-3">

  <!-- Perfil -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">

        <h2 class="h6">Meu Perfil</h2>

        <a class="btn btn-outline-primary btn-sm"
        href="<?= h(BASE_URL) ?>/private/perfil.php">

        Editar perfil

        </a>

        <a class="btn btn-outline-danger btn-sm ms-2"
        href="<?= h(BASE_URL) ?>/private/minha_conta_excluir.php">

        Excluir minha conta

        </a>

      </div>
    </div>
  </div>

  <?php if (($u['perfil'] ?? '') === 'admin'): ?>
  <!-- CRUD serviços -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">

        <h2 class="h6">Itens (CRUD)</h2>

        <a class="btn btn-outline-success btn-sm"
        href="<?= h(BASE_URL) ?>/private/itens_listar.php">

        Gerenciar itens

        </a>

      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Agendar serviço -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">

        <h2 class="h6">Agendamento</h2>

        <a class="btn btn-outline-primary btn-sm"
        href="<?= h(BASE_URL) ?>/private/agendar.php">

        Agendar serviço

        </a>

      </div>
    </div>
  </div>

  <!-- Meus agendamentos -->
  <div class="col-md-6">
    <div class="card h-100">
      <div class="card-body">

        <h2 class="h6">Meus Agendamentos</h2>

        <a class="btn btn-outline-dark btn-sm"
        href="<?= h(BASE_URL) ?>/private/meus_agendamentos.php">

        Visualizar agendamentos

        </a>

      </div>
    </div>
  </div>

  <?php if (($u['perfil'] ?? '') === 'admin'): ?>
  <!-- Administração -->
  <div class="col-md-6">
    <div class="card h-100 border-warning">
      <div class="card-body">

        <h2 class="h6">Administração</h2>

        <a class="btn btn-warning btn-sm"
        href="<?= h(BASE_URL) ?>/private/admin_usuarios.php">

        Listar/Excluir usuários

        </a>

      </div>
    </div>
  </div>
  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
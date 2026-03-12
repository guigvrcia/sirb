<?php
require_once __DIR__ . '/app/auth.php';
require_once __DIR__ . '/app/header.php';
?>

<div class="hero mb-5">
  <div class="hero-overlay">
    <div class="hero-content">

      <h1 class="display-5 fw-bold">
        💈 SIRB — Sistema de Reservas de Barbearia
      </h1>

      <p class="lead">
        Sistema web para facilitar o agendamento de serviços em uma barbearia,
        organizando a agenda e oferecendo área pública e privada.
      </p>

      <div class="mt-3">

        <a href="<?= h(BASE_URL) ?>/login.php" class="btn btn-warning btn-lg me-2">
          Entrar
        </a>

        <a href="<?= h(BASE_URL) ?>/cadastro.php" class="btn btn-light btn-lg">
          Criar conta
        </a>

      </div>

    </div>
  </div>
</div>

<section class="mb-5">

  <h2 class="text-center mb-4">Serviços da Barbearia</h2>

  <div class="row g-4 text-center">

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">✂ Corte Masculino</h3>
          <p>Corte tradicional ou moderno com acabamento profissional.</p>
          <p class="fw-bold">R$ 35,00</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">🧔 Barba</h3>
          <p>Modelagem e acabamento da barba com navalha.</p>
          <p class="fw-bold">R$ 25,00</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">💈 Corte + Barba</h3>
          <p>Pacote completo para visual renovado.</p>
          <p class="fw-bold">R$ 55,00</p>
        </div>
      </div>
    </div>

  </div>

</section>

<div class="row g-3">

  <div class="col-md-6">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h2 class="h5">Objetivo</h2>
        <p>
          Permitir cadastro e login de usuários, gerenciamento de serviços e organização
          de reservas para uma barbearia.
        </p>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card h-100 shadow-sm">
      <div class="card-body">
        <h2 class="h5">Como acessar</h2>
        <p>
          Utilize o botão de login ou cadastro acima para acessar o sistema.
          Após autenticação o usuário terá acesso à área privada.
        </p>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/app/footer.php'; ?>
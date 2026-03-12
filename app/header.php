<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

$user = $_SESSION['user'] ?? null;
$flash = flash_get();
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIRB</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= h(BASE_URL) ?>/public/css/styles.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">

    <a class="navbar-brand fw-bold" href="<?= h(BASE_URL) ?>/index.php">💈 SIRB</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="menu">
      <ul class="navbar-nav">

        <?php if ($user): ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= h(BASE_URL) ?>/private/dashboard.php">
              Área privada
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-warning" href="<?= h(BASE_URL) ?>/logout.php">
              Sair
            </a>
          </li>

        <?php else: ?>

          <li class="nav-item">
            <a class="nav-link" href="<?= h(BASE_URL) ?>/login.php">
              Login
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="<?= h(BASE_URL) ?>/cadastro.php">
              Criar conta
            </a>
          </li>

        <?php endif; ?>

      </ul>
    </div>

  </div>
</nav>

<main class="container my-4">

<?php if ($flash): ?>
  <div class="alert alert-<?= h($flash['type']) ?>">
    <?= h($flash['msg']) ?>
  </div>
<?php endif; ?>
<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$u = auth_user();

if (is_post()) {
    $pdo = db();
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->execute([$u['id']]);

    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit;
}

require_once __DIR__ . '/../app/header.php';
?>
<h1 class="h4 text-danger">Excluir minha conta</h1>
<p>Esta ação é irreversível.</p>

<form method="post">
  <button class="btn btn-danger">Confirmar exclusão</button>
  <a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/private/dashboard.php">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
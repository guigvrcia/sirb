<?php
require_once __DIR__ . '/../app/auth.php';
require_login();

$u = auth_user();
$nome = $u['nome'];
$email = $u['email'];

if (is_post()) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($nome === '' || $email === '') {
        flash_set('danger', 'Preencha nome e e-mail.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash_set('danger', 'E-mail inválido.');
    } else {
        $pdo = db();
        try {
            $stmt = $pdo->prepare("UPDATE usuarios SET nome=?, email=? WHERE id=?");
            $stmt->execute([$nome, $email, $u['id']]);

            $_SESSION['user']['nome'] = $nome;
            $_SESSION['user']['email'] = $email;

            flash_set('success', 'Perfil atualizado.');
            redirect(BASE_URL . '/private/dashboard.php');
        } catch (PDOException $e) {
            flash_set('danger', 'Não foi possível atualizar (e-mail pode já estar em uso).');
        }
    }
}

require_once __DIR__ . '/../app/header.php';
?>
<h1 class="h4">Editar Perfil</h1>

<form method="post" class="row g-3 needs-validation" novalidate>
  <div class="col-md-6">
    <label class="form-label">Nome</label>
    <input name="nome" class="form-control" value="<?= h($nome) ?>" required>
    <div class="invalid-feedback">Informe seu nome.</div>
  </div>

  <div class="col-md-6">
    <label class="form-label">E-mail</label>
    <input name="email" type="email" class="form-control" value="<?= h($email) ?>" required>
    <div class="invalid-feedback">Informe um e-mail válido.</div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Salvar</button>
    <a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/private/dashboard.php">Voltar</a>
  </div>
</form>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
<?php
require_once __DIR__ . '/app/auth.php';

$email = '';

if (is_post()) {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === '' || $senha === '') {
        flash_set('danger', 'Informe e-mail e senha.');
    } else {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $u = $stmt->fetch();

        if ($u && password_verify($senha, $u['senha_hash'])) {
            // login ok
            $_SESSION['user'] = [
                'id' => $u['id'],
                'nome' => $u['nome'],
                'email' => $u['email'],
                'perfil' => $u['perfil'],
            ];
            flash_set('success', 'Login realizado.');
            redirect(BASE_URL . '/private/dashboard.php');
        } else {
            flash_set('danger', 'Credenciais inválidas.');
        }
    }
}

require_once __DIR__ . '/app/header.php';
?>
<h1 class="h4">Login</h1>

<form method="post" class="row g-3 needs-validation" novalidate>
  <div class="col-md-6">
    <label class="form-label">E-mail</label>
    <input name="email" type="email" class="form-control" value="<?= h($email) ?>" required>
    <div class="invalid-feedback">Informe um e-mail válido.</div>
  </div>

  <div class="col-md-6">
    <label class="form-label">Senha</label>
    <input name="senha" type="password" class="form-control" required>
    <div class="invalid-feedback">Informe sua senha.</div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Entrar</button>
    <a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/cadastro.php">Criar conta</a>
  </div>

  <div class="col-12 mt-2">
  </div>
</form>

<?php require_once __DIR__ . '/app/footer.php'; ?>
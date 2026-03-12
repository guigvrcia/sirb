<?php
require_once __DIR__ . '/app/auth.php';

$nome = '';
$email = '';
$perfil = 'cliente';

if (is_post()) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    if ($nome === '' || $email === '' || $senha === '' || $senha2 === '') {
        flash_set('danger', 'Preencha todos os campos.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash_set('danger', 'E-mail inválido.');
    } elseif (strlen($senha) < 6) {
        flash_set('danger', 'A senha deve ter pelo menos 6 caracteres.');
    } elseif ($senha !== $senha2) {
        flash_set('danger', 'As senhas não conferem.');
    } else {
        try {
            $pdo = db();
            $sql = "INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->execute([$nome, $email, $hash, $perfil]);

            flash_set('success', 'Cadastro realizado. Faça login.');
            redirect(BASE_URL . '/login.php');
        } catch (PDOException $e) {
    flash_set('danger', 'Erro ao cadastrar: ' . $e->getMessage());
}
    }
}

require_once __DIR__ . '/app/header.php';
?>
<h1 class="h4">Cadastro</h1>

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

  <div class="col-md-6">
    <label class="form-label">Senha</label>
    <input name="senha" type="password" class="form-control" minlength="6" required>
    <div class="invalid-feedback">Senha mínima de 6 caracteres.</div>
  </div>

  <div class="col-md-6">
    <label class="form-label">Confirmar senha</label>
    <input name="senha2" type="password" class="form-control" minlength="6" required>
    <div class="invalid-feedback">Confirme a senha.</div>
  </div>

  <div class="col-12">
    <button class="btn btn-primary">Cadastrar</button>
    <a class="btn btn-outline-secondary" href="<?= h(BASE_URL) ?>/login.php">Já tenho conta</a>
  </div>
</form>

<?php require_once __DIR__ . '/app/footer.php'; ?>
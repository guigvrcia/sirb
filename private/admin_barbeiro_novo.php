<?php
require_once __DIR__ . '/../app/auth.php';
require_admin();

$pdo = db();
$mensagem = '';
$tipo_mensagem = '';

if (is_post()) {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    
    if ($nome === '' || $email === '' || $senha === '') {
        flash_set('danger', 'Preencha todos os campos.');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash_set('danger', 'E-mail inválido.');
    } elseif (strlen($senha) < 6) {
        flash_set('danger', 'A senha deve ter pelo menos 6 caracteres.');
    } else {
        try {
            $pdo->beginTransaction();
            
            // 1. Inserir na tabela usuarios
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash, perfil) VALUES (?, ?, ?, 'barbeiro')");
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $stmt->execute([$nome, $email, $hash]);
            $usuario_id = $pdo->lastInsertId();
            
            // 2. Inserir na tabela barbeiros
            $stmt = $pdo->prepare("INSERT INTO barbeiros (usuario_id, ativo) VALUES (?, 1)");
            $stmt->execute([$usuario_id]);
            
            $pdo->commit();
            
            flash_set('success', 'Barbeiro cadastrado com sucesso!');
            redirect(BASE_URL . '/private/admin_usuarios.php');
            
        } catch (PDOException $e) {
            $pdo->rollBack();
            flash_set('danger', 'Erro ao cadastrar. Verifique se o e-mail já está em uso.');
        }
    }
}

require_once __DIR__ . '/../app/header.php';
?>

<h1 class="h4">Cadastrar Novo Barbeiro</h1>

<form method="post" class="row g-3 needs-validation" novalidate>
    <div class="col-md-6">
        <label class="form-label">Nome completo</label>
        <input type="text" name="nome" class="form-control" value="<?= h($_POST['nome'] ?? '') ?>" required>
        <div class="invalid-feedback">Informe o nome do barbeiro.</div>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" value="<?= h($_POST['email'] ?? '') ?>" required>
        <div class="invalid-feedback">Informe um e-mail válido.</div>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" minlength="6" required>
        <div class="invalid-feedback">A senha deve ter pelo menos 6 caracteres.</div>
    </div>
    
    <div class="col-12">
        <button type="submit" class="btn btn-success">Cadastrar Barbeiro</button>
        <a href="<?= h(BASE_URL) ?>/private/admin_usuarios.php" class="btn btn-outline-secondary">Voltar</a>
    </div>
</form>

<?php require_once __DIR__ . '/../app/footer.php'; ?>
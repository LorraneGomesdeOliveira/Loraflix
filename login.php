<?php
session_start();
require_once 'bd.php';

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $sql = 'SELECT * FROM usuarios WHERE email = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['username'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_id'] = (int)$usuario['id'];

        header('Location: index.php');
        exit;
    }

    $erro = 'Email ou senha inválidos.';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Loraflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1 class="login-title">Login</h1>

            <?php if (!empty($erro)): ?>
                <p class="login-link" style="color: #f2e3c9; margin-bottom: 15px;">
                    <?= htmlspecialchars($erro) ?>
                </p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">E-mail :</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Senha :</label>
                    <input type="password" name="senha" class="form-input" required>
                </div>

                <button type="submit" class="btn-login">Entrar</button>
            </form>

            <div class="login-link">
                <p>Não tem conta? <a href="cadastro.php">Criar conta</a></p>
            </div>
        </div>
    </div>
</body>
</html>


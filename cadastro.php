<?php
require_once 'bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO usuarios (username, email, senha) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $email, $senha]);

        header("Location: login.php");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro: usuário ou email já existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Loraflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-box">
            <h1 class="login-title">Cadastro</h1>
            <?php if (!empty($erro)): ?>
                <p class="form-error"><?php echo $erro; ?></p>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label class="form-label">Nome de usuário :</label>
                    <input type="text" name="username" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">E-mail :</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Data de nascimento :</label>
                    <input type="date" name="nascimento" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Senha :</label>
                    <input type="password" name="senha" class="form-input" required>
                </div>
                <button type="submit" class="btn-login">Cadastrar</button>
            </form>
            <div class="login-link">
                <p>Já tem conta? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
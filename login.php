<?php
session_start();
require_once 'bd.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['username'];

        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Login</h2>
<div class="login-container">
    <div class="login-box">
        <h1 class="login-title">Login</h1>
        <form method="POST">
            <div class="form-group">
                <label class="form-label">E-mail :</label>
                <input type="email" name="email" class="form-input" placeholder="">         
</div>
<?php if(isset($erro)) echo "<p>$erro</p>"; ?>
            <div class="form-group">
                <label class="form-label">Senha :</label>
                <input type="password" name="senha" class="form-input" placeholder="">
            </div>
            <button type="submit" class="btn-login">Entrar</button>
        </form>
        <div class="login-link">
            <p>Não tem conta? <a href="cadastro.php">Criar conta</a></p>
        </div>
    </div>      

</body>
</html>


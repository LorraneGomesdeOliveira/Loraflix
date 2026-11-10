<?php
session_start();
require_once 'bd.php';

if (empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuarioId = (int)$_SESSION['usuario_id'];
$conteudoId = (int)($_POST['conteudo_id'] ?? 0);
$redirect = $_POST['redirect'] ?? 'index.php';

if ($conteudoId > 0) {
    $check = $pdo->prepare('SELECT 1 FROM favoritos WHERE usuario_id = ? AND conteudo_id = ?');
    $check->execute([$usuarioId, $conteudoId]);

    if ($check->fetchColumn()) {
        $stmt = $pdo->prepare('DELETE FROM favoritos WHERE usuario_id = ? AND conteudo_id = ?');
        $stmt->execute([$usuarioId, $conteudoId]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO favoritos (usuario_id, conteudo_id) VALUES (?, ?)');
        $stmt->execute([$usuarioId, $conteudoId]);
    }
}

header('Location: ' . $redirect);
exit;

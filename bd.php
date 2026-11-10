<?php
$host = "localhost";
$db   = "loraflix_db";
$user = "root";
$pass = "1234";

try {
    $pdo = new PDO("mysql:host=localhost;dbname=loraflix_db;charset=utf8", "root", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS favoritos (
            usuario_id INT NOT NULL,
            conteudo_id INT NOT NULL,
            PRIMARY KEY (usuario_id, conteudo_id),
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (conteudo_id) REFERENCES conteudos(id) ON DELETE CASCADE
        )
    ");
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>


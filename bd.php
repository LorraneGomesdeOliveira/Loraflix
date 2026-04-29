<?php
$host = "localhost";
$db   = "loraflix_db";
$user = "root";
$pass = "1234"; // Coloque sua senha se houver

try {
    $pdo = new PDO("mysql:host=localhost;dbname=loraflix_db;charset=utf8", "root", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}
?>


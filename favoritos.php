<?php
session_start();
require_once 'bd.php';
require_once 'functions.php';

if (empty($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

$usuarioId = (int)$_SESSION['usuario_id'];

$stmt = $pdo->prepare(
    "SELECT c.id, c.titulo, c.capa_url, GROUP_CONCAT(g.nome SEPARATOR ' | ') as lista_generos
     FROM favoritos f
     JOIN conteudos c ON c.id = f.conteudo_id
     LEFT JOIN conteudo_generos cg ON c.id = cg.conteudo_id
     LEFT JOIN generos g ON cg.genero_id = g.id
     WHERE f.usuario_id = ?
     GROUP BY c.id
     ORDER BY c.titulo ASC"
);
$stmt->execute([$usuarioId]);
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos - Loraflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php $activePage = ''; include 'includes/header.php'; ?>

<main class="container">
    <h2 class="section-title">Meus favoritos</h2>
    <div class="movie-grid">
        <?php if (!empty($favoritos)): ?>
            <?php foreach ($favoritos as $item): ?>
                <div class="movie-card">
                    <a href="detalhes.php?id=<?= (int)$item['id'] ?>" class="movie-card-link">
                        <img src="<?= htmlspecialchars(get_image_path($item['capa_url'])) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($item['titulo']) ?></h3>
                            <p><?= htmlspecialchars($item['lista_generos']) ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Você ainda não marcou nenhum favorito.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

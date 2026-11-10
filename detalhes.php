<?php
session_start();
require_once 'bd.php';
require_once 'functions.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare(
    "SELECT c.*, GROUP_CONCAT(g.nome SEPARATOR ' | ') as lista_generos
     FROM conteudos c
     LEFT JOIN conteudo_generos cg ON c.id = cg.conteudo_id
     LEFT JOIN generos g ON cg.genero_id = g.id
     WHERE c.id = ?
     GROUP BY c.id"
);
$stmt->execute([$id]);
$conteudo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conteudo) {
    header('Location: index.php');
    exit;
}

$temporadasStmt = $pdo->prepare(
    "SELECT * FROM temporadas WHERE conteudo_id = ? ORDER BY numero_temporada ASC"
);
$temporadasStmt->execute([$id]);
$temporadas = $temporadasStmt->fetchAll(PDO::FETCH_ASSOC);

$usuarioId = !empty($_SESSION['usuario_id']) ? (int)$_SESSION['usuario_id'] : 0;
$isFavorito = false;

if ($usuarioId > 0) {
    $favStmt = $pdo->prepare('SELECT 1 FROM favoritos WHERE usuario_id = ? AND conteudo_id = ?');
    $favStmt->execute([$usuarioId, $id]);
    $isFavorito = (bool)$favStmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($conteudo['titulo']) ?> - Loraflix</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <nav class="navbar">
        <div class="logo">LORA<span>FLIX</span></div>
        <ul class="nav-links">
            <li><a href="index.php">INÍCIO</a></li>
            <li><a href="filmes.php">FILMES</a></li>
            <li><a href="series.php">SÉRIES</a></li>
            <?php if (!empty($_SESSION['usuario'])): ?>
                <li><a href="logout.php">SAIR</a></li>
            <?php else: ?>
                <li><a href="login.php">ENTRAR</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="detail-page">
    <div class="detail-card">
        <h2 class="section-title"><?= htmlspecialchars($conteudo['titulo']) ?></h2>
        <img src="<?= htmlspecialchars(get_image_path($conteudo['capa_url'])) ?>" alt="<?= htmlspecialchars($conteudo['titulo']) ?>" style="max-width: 260px; border-radius: 12px; border: 2px solid #630b0b; margin-bottom: 20px;">

        <div class="detail-meta">
            <p><strong>Tipo:</strong> <?= htmlspecialchars($conteudo['tipo']) ?></p>
            <p><strong>Ano:</strong> <?= (int)$conteudo['ano_lancamento'] ?></p>
            <p><strong>Gêneros:</strong> <?= htmlspecialchars($conteudo['lista_generos']) ?></p>
            <p><strong>Sinopse:</strong> <?= nl2br(htmlspecialchars($conteudo['sinopse'])) ?></p>
        </div>

        <?php if (!empty($_SESSION['usuario'])): ?>
            <form method="POST" action="toggle_favorito.php" class="favorite-form">
                <input type="hidden" name="conteudo_id" value="<?= (int)$conteudo['id'] ?>">
                <input type="hidden" name="redirect" value="detalhes.php?id=<?= (int)$conteudo['id'] ?>">
                <button type="submit" class="btn-favorite">
                    <?= $isFavorito ? '★ Remover dos favoritos' : '☆ Adicionar aos favoritos' ?>
                </button>
            </form>
        <?php else: ?>
            <p class="favorite-tip">Faça login para salvar este conteúdo nos favoritos.</p>
        <?php endif; ?>

        <?php if (!empty($temporadas)): ?>
            <div class="detail-meta">
                <p><strong>Temporadas:</strong></p>
                <ul class="season-list">
                    <?php foreach ($temporadas as $temporada): ?>
                        <li>Temporada <?= (int)$temporada['numero_temporada'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

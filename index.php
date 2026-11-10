<?php
session_start();
require_once 'bd.php';
require_once 'functions.php';

$busca = trim($_GET['q'] ?? '');
$params = [];
$sql = "
    SELECT c.*, GROUP_CONCAT(g.nome SEPARATOR ' | ') as lista_generos 
    FROM conteudos c
    LEFT JOIN conteudo_generos cg ON c.id = cg.conteudo_id
    LEFT JOIN generos g ON cg.genero_id = g.id
";

if (!empty($busca)) {
    $sql .= " WHERE c.titulo LIKE ? OR c.sinopse LIKE ?";
    $params = ["%$busca%", "%$busca%"];
}

$sql .= " GROUP BY c.id ORDER BY c.titulo ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$catalogo = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loraflix - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php $activePage = 'home'; include 'includes/header.php'; ?>

<section class="hero-banner">
    <div class="banner-wrapper">
        <img src="assets/img/Loraflix.png" alt="Loraflix" class="img-base">

        <div class="btn-overlay-container">
            <a href="filmes.php" class="btn-link-overlay">
                <button class="btn-invisible">ENTRAR</button>
            </a>
        </div>
    </div>
</section>

<main class="container">
    <?php if (!empty($_SESSION['usuario'])): ?>
        <p class="section-title" style="margin-bottom: 20px; border-left: 5px solid #630b0b; padding-left: 15px;">
            Olá, <?= htmlspecialchars($_SESSION['usuario']) ?>! Bem-vindo(a) à Loraflix.
        </p>
    <?php endif; ?>

    <h2 class="section-title">Estreias Loraflix</h2>
    <div class="movie-grid">
        <?php if (!empty($catalogo)): ?>
            <?php foreach ($catalogo as $filme): ?>
                <div class="movie-card">
                    <img src="<?= htmlspecialchars(get_image_path($filme['capa_url'])) ?>" alt="<?= htmlspecialchars($filme['titulo']) ?>">
                    <div class="movie-info">
                        <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                        <p><?= htmlspecialchars($filme['lista_generos']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum conteúdo encontrado.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
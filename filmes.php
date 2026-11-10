<?php
session_start();
require_once 'bd.php';
require_once 'functions.php';

$busca = trim($_GET['q'] ?? '');
$params = [];
$sql = "SELECT c.*, GROUP_CONCAT(g.nome SEPARATOR ' | ') as lista_generos
    FROM conteudos c
    LEFT JOIN conteudo_generos cg ON c.id = cg.conteudo_id
    LEFT JOIN generos g ON cg.genero_id = g.id
    WHERE c.tipo = 'Filme'";

if (!empty($busca)) {
    $sql .= " AND (c.titulo LIKE ? OR c.sinopse LIKE ?)";
    $params = ["%$busca%", "%$busca%"];
}

$sql .= " GROUP BY c.id ORDER BY c.titulo ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loraflix - Filmes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php $activePage = 'filmes'; include 'includes/header.php'; ?>

<main class="container">
    <form method="GET" class="search-form">
        <input type="text" name="q" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar filme" class="search-field">
        <button type="submit" class="btn-search">Buscar</button>
    </form>

    <h2 class="section-title">Filmes</h2>
    <div class="movie-grid">
        <?php if (!empty($filmes)): ?>
            <?php foreach ($filmes as $filme): ?>
                <div class="movie-card">
                    <a href="detalhes.php?id=<?= (int)$filme['id'] ?>" class="movie-card-link">
                        <img src="<?= htmlspecialchars(get_image_path($filme['capa_url'])) ?>" alt="<?= htmlspecialchars($filme['titulo']) ?>">
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($filme['titulo']) ?></h3>
                            <p><?= htmlspecialchars($filme['lista_generos']) ?></p>
                            <span class="movie-link">Ver detalhes</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum filme encontrado.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

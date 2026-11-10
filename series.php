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
    WHERE c.tipo = 'Serie'";

if (!empty($busca)) {
    $sql .= " AND (c.titulo LIKE ? OR c.sinopse LIKE ?)";
    $params = ["%$busca%", "%$busca%"];
}

$sql .= " GROUP BY c.id ORDER BY c.titulo ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$series = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loraflix - Séries</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php $activePage = 'series'; include 'includes/header.php'; ?>

<main class="container">
    <form method="GET" class="search-form">
        <input type="text" name="q" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar série" class="search-field">
        <button type="submit" class="btn-search">Buscar</button>
    </form>

    <h2 class="section-title">Séries</h2>
    <div class="movie-grid">
        <?php if (!empty($series)): ?>
            <?php foreach ($series as $serie): ?>
                <div class="movie-card">
                    <a href="detalhes.php?id=<?= (int)$serie['id'] ?>" class="movie-card-link">
                        <img src="<?= htmlspecialchars(get_image_path($serie['capa_url'])) ?>" alt="<?= htmlspecialchars($serie['titulo']) ?>">
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($serie['titulo']) ?></h3>
                            <p><?= htmlspecialchars($serie['lista_generos']) ?></p>
                            <span class="movie-link">Ver detalhes</span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma série encontrada.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>

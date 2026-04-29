<?php
require_once 'bd.php'; // Conecta ao banco de dados

// Busca os filmes e gêneros
$query = $pdo->query("
    SELECT c.*, GROUP_CONCAT(g.nome SEPARATOR ' | ') as lista_generos 
    FROM conteudos c
    LEFT JOIN conteudo_generos cg ON c.id = cg.conteudo_id
    LEFT JOIN generos g ON cg.genero_id = g.id
    GROUP BY c.id ORDER BY c.id ASC
");
$catalogo = $query->fetchAll(PDO::FETCH_ASSOC);
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
     
<header>
    <nav class="navbar">
        <!-- Logo com as cores do seu banner -->
        <div class="logo">LORA<span>FLIX</span></div>
        
        <!-- Links de Navegação -->
        <ul class="nav-links">
            <li><a href="index.php" class="active">INÍCIO</a></li>
            <li><a href="filmes.html">FILMES</a></li>
            <li><a href="series.html">SÉRIES</a></li>
            <li><a href="login.php">ENTRAR</a></li>
        </ul>

        <!-- Barra de busca rápida (opcional) -->
        <div class="nav-search">
            <input type="text" placeholder="Buscar..." class="search-field">
        </div>
    </nav>
</header>
<!-- Banner com o botão sobreposto ao desenho -->
    <section class="hero-banner">
        <div class="banner-wrapper">
            <!-- Sua imagem PNG -->
            <img src="assets/img/banner-principal.png" alt="Loraflix" class="img-base">
            
            <!-- O botão invisível ou estilizado exatamente no centro -->
            <div class="btn-overlay-container">
                <a href="filmes.html" class="btn-link-overlay">
                    <button class="btn-invisible">ENTRAR</button>
                </a>
            </div>
        </div>
    </section>

    <main class="container">
        <h2 class="section-title">Estreias Loraflix</h2>
        <div class="movie-grid">
    <?php if (!empty($catalogo)): ?>
        <?php foreach($catalogo as $filme): ?>
            <div class="movie-card">
                <img src="assets/img/<?php echo htmlspecialchars($filme['capa_url']); ?>" alt="<?php echo htmlspecialchars($filme['titulo']); ?>">
                <div class="movie-info">
                    <h3><?php echo htmlspecialchars($filme['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($filme['lista_generos']); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum filme encontrado.</p>
    <?php endif; ?>
</div>

    </main>

</body>
</html>
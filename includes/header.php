<?php
if (!isset($activePage)) {
    $activePage = '';
}
?>
<header>
    <nav class="navbar">
        <a href="index.php" class="logo">LORA<span>FLIX</span></a>

        <ul class="nav-links">
            <li><a href="index.php" class="<?= $activePage === 'home' ? 'active' : '' ?>">INÍCIO</a></li>
            <li><a href="filmes.php" class="<?= $activePage === 'filmes' ? 'active' : '' ?>">FILMES</a></li>
            <li><a href="series.php" class="<?= $activePage === 'series' ? 'active' : '' ?>">SÉRIES</a></li>
        </ul>

        <div class="nav-actions">
            <?php if (!empty($_SESSION['usuario'])): ?>
                <a href="favoritos.php" class="nav-pill">FAVORITOS</a>
                <a href="logout.php" class="nav-pill">SAIR</a>
            <?php else: ?>
                <a href="login.php" class="nav-pill">ENTRAR</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

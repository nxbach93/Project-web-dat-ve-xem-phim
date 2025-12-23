<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Logo -->
    <h1>
        <a href="/project/formTrangChu.php">Cinemas</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="/project/phim/phim.php">PHIM</a></li>
            <li><a href="/project/rap/rap.php">RẠP</a></li>
            <li><a href="/project/lichchieu/lichchieu.php">LỊCH CHIẾU</a></li>
            <li><a href="/project/giave/giave.php">GIÁ VÉ</a></li>
            <li><a href="/project/tintuc/tintuc.php">TIN TỨC</a></li>
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/project/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/project/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>


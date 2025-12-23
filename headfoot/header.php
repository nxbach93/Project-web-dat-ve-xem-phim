<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Header CSS -->
<link rel="stylesheet" href="/Mua_Ve_Di/headfoot/header.css">

<header>
    <!-- Logo -->
    <h1>
        <a href="/Mua_Ve_Di/trangchu/formTrangChu.php">Cinemas</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="/Mua_Ve_Di/phim/phim.php">Phim</a></li>
            <li><a href="/Mua_Ve_Di/rap/rap.php">Rạp</a></li>
            <li><a href="/Mua_Ve_Di/LichChieu/Form_LichChieu.php">Lịch chiếu</a></li>
            <li><a href="/Mua_Ve_Di/giave/giave.php">Giá vé</a></li>
            <li><a href="/Mua_Ve_Di/tintuc/tintuc.php">Tin tức</a></li>
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/Mua_Ve_Di/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/Mua_Ve_Di/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

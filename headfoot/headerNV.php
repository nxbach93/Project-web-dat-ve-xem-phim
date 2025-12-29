<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Logo -->
    <h1>
        <a href="/project/trangchu/formTrangChuNV.php">Cinemas</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="/project/Staff/phim_admin/phimAdmin.php">Phim</a></li>
            <li><a href="/project/rap/rapNV.php">Rạp</a></li>
            <li><a href="/project/lichchieu/lichchieuNV.php">Lịch chiếu</a></li>
            <li><a href="/project/giave/giaveNV.php">Giá vé</a></li>
            <li><a href="/project/tintuc/tintucNV.php">Tin tức</a></li>
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


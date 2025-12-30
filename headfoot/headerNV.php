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
            <li><a href="/Project_Web/Staff/phim_admin/phimAdmin.php">Phim</a></li>
            <li><a href="/Project_Web/rap/rapNV.php">Rạp</a></li>
            <li><a href="/Project_Web/LichChieu/lichchieuNV.php">Lịch chiếu</a></li>
            <li><a href="/Project_Web/giave/giaveNV.php">Giá vé</a></li>
            <li><a href="/Project_Web/tintuc/tintucNV.php">Tin tức</a></li>
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/Project_Web/DangNhap/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/Project_Web/DangNhap/formDangNhapNV.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
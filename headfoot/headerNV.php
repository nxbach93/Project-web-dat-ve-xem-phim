<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <h1>
        <a href="/Project_Web/TrangChu/formTrangChuNV.php">Cinemas</a>
    </h1>

    <nav>
        <ul>
            <li><a href="/Project_Web/Staff/phim_admin/phimAdmin.php">Phim</a></li>
            <li><a href="/Project_Web/rap/rapNV.php">Rạp</a></li>
            <li><a href="/Project_Web/Admin/admin.php">Lịch chiếu</a></li>
            <li><a href="/Project_Web/giave/giaveNV.php">Giá vé</a></li>
            <li><a href="/Project_Web/tintuc/tintucNV.php">Tin tức</a></li>
        </ul>
    </nav>

    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/Project_Web/DangNhap/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/Project_Web/DangNhap/formDangNhapNV.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Logo -->
    <h1>
        <a href="../TrangChu/formTrangChu.php">Cinemas</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="../Phim/phim.php">Phim</a></li>
            <li><a href="../Rap/rap.php">Rạp</a></li>
            <li><a href="../LichChieu/lichchieu.php">Lịch chiếu</a></li>
            <li><a href="../GiaVe/giave.php">Giá vé</a></li>
            <li><a href="../TinTuc/formTinTuc.php">Tin tức</a></li>
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span><?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="../DangNhap/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="../DangNhap/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

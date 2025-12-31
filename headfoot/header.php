<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <h1>

        <a href="/Project_Web/trangchu/formTrangChu.php">Cinemas</a>
    </h1>

    <nav>
        <ul>
            <li><a href="/Project_Web/phim/phim.php">PHIM</a></li>
            <li><a href="/Project_Web/rap/rap.php">RẠP</a></li>
            <li><a href="/Project_Web/LichChieu/Form_LichChieu.php">LỊCH CHIẾU</a></li>
            <li><a href="/Project_Web/Giave/giave.php">GIÁ VÉ</a></li>
            <li><a href="/Project_Web/TinTuc/formTinTuc.php">TIN TỨC</a></li>

        </ul>
    </nav>

    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/Project_Web/DangNhap/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/Project_Web/DangNhap/formDangNhapKH.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
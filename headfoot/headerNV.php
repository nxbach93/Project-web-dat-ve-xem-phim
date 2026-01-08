<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Logo -->
    <h1>
        <a href="../TrangChu/formTrangChuNV.php">Cinemas</a>
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="../phim/phim.php">Phim</a></li>
            <li><a href="../rap/rapNV.php">Rạp</a></li>
            <li><a href="../LichChieu/Form_LichChieu.php">Lịch chiếu</a></li>
            <li><a href="../Giave/giave.php">Giá vé</a></li>
            <li><a href="../TinTuc/formTinTuc.php">Tin tức</a></li>
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
                <a href="#" class="dropbtn"><?= htmlspecialchars($_SESSION['username']) ?> ▼</a>
                <div class="dropdown-content">
                    <a href="../ThongTinTaiKhoan/ThongTinTKNhanVien.php">Thông tin tài khoản</a>
                    <a href="../DangNhap/logout.php">Đăng xuất</a>
                </div>
            </div>
        <?php else: ?>
            <a href="../DangNhap/formDangNhap.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

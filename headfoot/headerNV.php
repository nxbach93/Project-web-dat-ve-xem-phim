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
<<<<<<< HEAD
            <li><a href="/project/Staff/phim_admin/phimAdmin.php">Phim</a></li>
            <li><a href="/project/rap/rapNV.php">Rạp</a></li>
            <li><a href="/project/lichchieu/lichchieuNV.php">Lịch chiếu</a></li>
            <li><a href="/project/giave/giaveNV.php">Giá vé</a></li>
            <li><a href="/project/tintuc/tintucNV.php">Tin tức</a></li>
=======
            <li><a href="/project/phim/phimNV.php">Phim</a></li>
            <li><a href="/project/rap/rapNV.php">Rạp</a></li>
            <li><a href="/project/lichchieu/lichchieuNV.php">Lịch chiếu</a></li>
            <li><a href="/project/giave/giaveNV.php">Giá vé</a></li>
            <li><a href="../TinTuc/formTinTuc.php">Tin tức</a></li>
>>>>>>> origin/Form_TinTucVaUuDai
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
<<<<<<< HEAD
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="/project/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/project/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

=======
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
>>>>>>> origin/Form_TinTucVaUuDai

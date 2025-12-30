<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<<<<<<< HEAD
<<<<<<< HEAD
<header>
    <!-- Logo -->
    <h1>
<<<<<<< HEAD
        <a href="/project/formTrangChu.php">Cinemas</a>
=======
<!-- Header CSS -->
<link rel="stylesheet" href="/Mua_Ve_Di/headfoot/header.css">

<header>
    <!-- Logo -->
    <h1>
        <a href="/Mua_Ve_Di/trangchu/formTrangChu.php">Cinemas</a>
>>>>>>> origin/Form_LichChieu
=======

        <a href="/project/trangchu/formTrangChu.php">Cinemas</a>
>>>>>>> origin/Form_Phim
=======
<header>
    <!-- Logo -->
    <h1>
        <a href="../TrangChu/formTrangChu.php">Cinemas</a>
>>>>>>> origin/Form_TinTucVaUuDai
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
            <li><a href="/project/phim/phim.php">Phim</a></li>
            <li><a href="/project/rap/rap.php">Rạp</a></li>
            <li><a href="/project/lichchieu/lichchieu.php">Lịch chiếu</a></li>
            <li><a href="/project/giave/giave.php">Giá vé</a></li>
            <li><a href="/project/tintuc/tintuc.php">Tin tức</a></li>
=======
            <li><a href="/Mua_Ve_Di/phim/phim.php">Phim</a></li>
            <li><a href="/Mua_Ve_Di/rap/rap.php">Rạp</a></li>
            <li><a href="/Mua_Ve_Di/LichChieu/Form_LichChieu.php">Lịch chiếu</a></li>
            <li><a href="/Mua_Ve_Di/giave/giave.php">Giá vé</a></li>
            <li><a href="/Mua_Ve_Di/tintuc/tintuc.php">Tin tức</a></li>
>>>>>>> origin/Form_LichChieu
=======
            <li><a href="/project/phim/phim.php">PHIM</a></li>
            <li><a href="/project/rap/rap.php">RẠP</a></li>
            <li><a href="/project/lichchieu/lichchieu.php">LỊCH CHIẾU</a></li>
            <li><a href="/project/giave/giave.php">GIÁ VÉ</a></li>
            <li><a href="/project/tintuc/tintuc.php">TIN TỨC</a></li>

>>>>>>> origin/Form_Phim
=======
            <li><a href="../Phim/phim.php">Phim</a></li>
            <li><a href="../Rap/rap.php">Rạp</a></li>
            <li><a href="../LichChieu/lichchieu.php">Lịch chiếu</a></li>
            <li><a href="../GiaVe/giave.php">Giá vé</a></li>
            <li><a href="../TinTuc/formTinTuc.php">Tin tức</a></li>
>>>>>>> origin/Form_TinTucVaUuDai
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
<<<<<<< HEAD
            <span>Welcome: <?= htmlspecialchars($_SESSION['username']) ?></span>
<<<<<<< HEAD
            <a href="/project/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/project/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>

=======
            <a href="/Mua_Ve_Di/logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="/Mua_Ve_Di/login.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
>>>>>>> origin/Form_LichChieu
=======
            <div class="dropdown">
                <a href="#" class="dropbtn"><?= htmlspecialchars($_SESSION['username']) ?> ▼</a>
                <div class="dropdown-content">
                    <a href="../ThongTinTaiKhoan/ThongTinTKKhach.php">Thông tin tài khoản</a>
                    <a href="../DangNhap/logout.php">Đăng xuất</a>
                </div>
            </div>
        <?php else: ?>
            <a href="../DangNhap/formDangNhap.php">Đăng nhập</a>
        <?php endif; ?>
    </div>
</header>
>>>>>>> origin/Form_TinTucVaUuDai

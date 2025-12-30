<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
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
    </h1>

    <!-- Navigation -->
    <nav>
        <ul>
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
        </ul>
    </nav>

    <!-- Auth -->
    <div class="auth">
        <?php if (isset($_SESSION['username'])): ?>
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

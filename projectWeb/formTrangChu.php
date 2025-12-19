
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Đặt vé phim</title>
    <link rel="stylesheet" href="formTrangChu.css">
</head>

<body>
<header>
    <h1><a href="formTrangChu.php">Trang Chủ</a></h1>

    <nav>
        <ul>
            <li><a href="phim.php">Phim</a></li>
            <li><a href="rap.php">Rạp</a></li>
            <li><a href="lichchieu.php">Lịch chiếu</a></li>
            <li><a href="giave.php">Thông tin giá vé</a></li>
            <li><a href="tintuc.php">Tin tức & Ưu đãi</a></li>
        </ul>
    </nav>

    <div class="auth">
        <?php if (isset($_SESSION['user'])): ?>
            <span>Xin chào, <?php echo $_SESSION['user']; ?></span>
            <a href="logout.php">Đăng xuất</a>
        <?php else: ?>
            <a href="login.php">Đăng nhập / Đăng ký</a>
        <?php endif; ?>
    </div>
</header>

<main>
 <!-- code trong nay -->

</main>
</body>
</html>

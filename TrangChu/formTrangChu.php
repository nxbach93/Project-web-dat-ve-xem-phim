<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Đặt vé phim</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="formTrangChu.css">
</head>

<body>

<?php include "../headfoot/header.php"; ?>

<main class="home">

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h2>Xem phim bom tấn mới nhất</h2>
            <p>Đặt vé nhanh – Chọn ghế dễ – Trải nghiệm đã</p>
            <a href="/project/phim/phim.php" class="btn-primary">Xem phim ngay</a>
        </div>
    </section>

    <!-- PHIM ĐANG CHIẾU -->
    <section class="section">
        <h3>🎬 Phim đang chiếu</h3>

        <div class="movie-preview">
            <!-- Sau này load từ database -->
            <div class="movie-item" style ="width: 50px;">
                <img src="images/movie/inception.png" alt="Inception">
                <h4>Inception</h4>
            </div>

            <div class="movie-item">
                <img src="images/movie/parasite.png" alt="Parasite">
                <h4>Parasite</h4>
            </div>
        </div>

        <a href="phim/phim.php" class="see-more">Xem tất cả →</a>
    </section>

    <!-- ƯU ĐÃI -->
    <section class="section dark">
        <h3>🔥 Ưu đãi & Khuyến mãi</h3>
        <p>Giảm giá vé sinh viên – Combo bắp nước siêu rẻ</p>
    </section>

</main>

</body>
</html>

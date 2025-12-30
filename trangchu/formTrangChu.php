<?php
session_start();
<<<<<<< HEAD
=======
include('../headfoot/connect.php'); 

                $today = date('Y-m-d');
>>>>>>> origin/Form_Phim
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

<<<<<<< HEAD
<?php include "../headfoot/header.php"; ?>
=======
<?php include('../headfoot/header.php'); ?>
>>>>>>> origin/Form_Phim

<main class="home">

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <h2>Xem phim bom tấn mới nhất</h2>
            <p>Đặt vé nhanh – Chọn ghế dễ – Trải nghiệm đã</p>
<<<<<<< HEAD
            <a href="/project/phim/phim.php" class="btn-primary">Xem phim ngay</a>
=======
            <a href="../phim/phim.php" class="btn-primary">Xem phim ngay</a>
>>>>>>> origin/Form_Phim
        </div>
    </section>

    <!-- PHIM ĐANG CHIẾU -->
    <section class="section">
        <h3>🎬 Phim đang chiếu</h3>

        <div class="movie-preview">
<<<<<<< HEAD
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
=======
            <?php
                    $sql_dang_chieu = "
                        SELECT DISTINCT p.idphim, p.tenphim, p.thoiluong, p.poster
                        FROM qlphim p JOIN qllichchieu lc ON p.IDPhim = lc.IDPhim
                        WHERE lc.ngaychieu <= '$today'
                    ";


                    $result_dang_chieu = $conn->query($sql_dang_chieu);

                    if ($result_dang_chieu->num_rows > 0) {
                        while ($row = $result_dang_chieu->fetch_assoc()) {
                            echo '<div class="movie">';
                            echo '<img src="' . $row['poster'] . '" alt="Poster phim">';
                            echo '<h3>' . $row['tenphim'] . '</h3>';
                            echo '<p>Thời lượng: ' . $row['thoiluong'] . ' phút</p>';
                            echo '<div class="btn-group">'; 
                            echo '<a href="chitietphim.php?id=' . $row['idphim'] . '">Xem chi tiết</a>';  
                            if (isset($_SESSION['user'])) {
                                echo '<a href="datve.php?id=' . $row['idphim'] . '">Đặt vé</a>';
                            } else {
                                echo '<a href="login.php">Đặt vé</a>';
                            }
                            echo '</div>';

                            echo '</div>';
                        }
                    } else {
                        echo '<p>Hiện không có phim đang chiếu.</p>';
                    }

                    ?>
        </div>

        <a href="../phim/phim.php" class="see-more">Xem tất cả →</a>
>>>>>>> origin/Form_Phim
    </section>

    <!-- ƯU ĐÃI -->
    <section class="section dark">
<<<<<<< HEAD
        <h3>🔥 Ưu đãi & Khuyến mãi</h3>
        <p>Giảm giá vé sinh viên – Combo bắp nước siêu rẻ</p>
    </section>

=======
        <h4>📅 Phim sắp khởi chiếu</h4>
        <?php
        $sql_sap_chieu = "
            SELECT idphim, tenphim, ngaykhoichieu, poster
            FROM qlphim
            WHERE ngaykhoichieu > '$today'
            ORDER BY ngaykhoichieu ASC
        ";


        $result_sap_chieu = $conn->query($sql_sap_chieu);

        if ($result_sap_chieu->num_rows > 0) {
            while ($row = $result_sap_chieu->fetch_assoc()) {
                echo '<div class="movie">';
                echo '<img src="' . $row['poster'] . '" alt="Poster phim">';
                echo '<h3>' . $row['tenphim'] . '</h3>';
                echo '<p>Khởi chiếu: ' . date('d/m/Y', strtotime($row['ngaykhoichieu'])) . '</p>';
                echo '<div class="btn-group">'; 
                echo '<a href="chitietphim.php?id=' . $row['idphim'] . '">Xem chi tiết</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Hiện không có phim sắp chiếu.</p>';
        }

        $conn->close();
        ?>
    </section>

    

>>>>>>> origin/Form_Phim
</main>

</body>
</html>
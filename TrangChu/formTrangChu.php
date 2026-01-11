<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    unset($_SESSION['username']);
    header("Location: formTrangChu.php");
    exit();
}
    $today = date('Y-m-d');
    require_once "../headfoot/connect.php";
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
            <a href="../phim/phim.php" class="btn-primary">Xem phim ngay</a>
        </div>
    </section>

    <!-- PHIM ĐANG CHIẾU -->
    <section class="section">
        <h3>🎬 Phim đang chiếu</h3>

        <div class="movie-preview">
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
                            echo '<img src="../images/movie/' . $row['poster'] . '" alt="Poster phim">';
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
    </section>

    <!-- ƯU ĐÃI -->
    <section class="section dark">
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

    

</main>

</body>
</html>

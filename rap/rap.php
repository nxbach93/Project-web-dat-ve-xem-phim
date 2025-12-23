<?php
session_start();
// Nhúng file kết nối từ thư mục headfoot
include('../headfoot/connect.php'); 
$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Rạp - Cinema Center</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="rap.css">
</head>
<body>

<?php include('../headfoot/header.php'); ?>

<main class="home">
    <h2 class="section-title">Hệ Thống Rạp Chiếu</h2>

    <?php
    $sql_rap = "SELECT * FROM rap";
    $result_rap = $conn->query($sql_rap);

    if ($result_rap && $result_rap->num_rows > 0) {
        while($rap = $result_rap->fetch_assoc()) {
            $idRap = $rap['IDRap'];
            $map_url = "https://www.google.com/maps/search/" . urlencode($rap['DiaChi']);
            ?>

            <div class="cinema-item">
                <div class="cinema-details">
                    <h3><?php echo $rap['TenRap']; ?></h3>
                    <p class="info-row"><strong>📍 Địa chỉ:</strong> <a href="<?php echo $map_url; ?>" target="_blank"><?php echo $rap['DiaChi']; ?></a></p>
                    <p class="info-row"><strong>📞 Hotline:</strong> <?php echo $rap['Hotline']; ?></p>
                    <p class="info-row"><strong>👏Giới thiệu:</strong> <?php echo $rap['GioiThieu']; ?></p>
                </div>

                <div class="cinema-current-movie">
                    <h4>🎬 Phim đang chiếu tại rạp này:</h4>
                    <div class="list-movies">
                        <?php 
                        $sql_phim = "SELECT DISTINCT p.* FROM qlphim p 
                                     INNER JOIN qllichchieu lc ON p.IDPhim = lc.IDPhim 
                                     WHERE lc.IDRap = '$idRap' AND lc.ngaychieu <= '$today'";
                        
                        $result_phim = $conn->query($sql_phim);

                        if ($result_phim && $result_phim->num_rows > 0) {
                            while($phim = $result_phim->fetch_assoc()) {
                                ?>
                                <div class="movie-card">
                                    <img src="<?php echo $phim['Poster']; ?>" alt="Poster">
                                    <p class="movie-name"><?php echo $phim['TenPhim']; ?></p>
                                    <a href="../chitietphim.php?id=<?php echo $phim['IDPhim']; ?>" class="btn-detail">Chi tiết</a>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<p class="no-movie">Hiện rạp này chưa có lịch chiếu phim.</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
        }
    } else {
        echo '<p>Không tìm thấy rạp nào.</p>';
    }
    $conn->close();
    ?>
</main>

</body>
</html>
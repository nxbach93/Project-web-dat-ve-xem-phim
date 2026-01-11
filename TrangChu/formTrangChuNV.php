<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    unset($_SESSION['username']);
    header("Location: formTrangChuNV.php");
    exit();
}
include('../headfoot/connect.php'); 

                $today = date('Y-m-d');
// 1. Lấy doanh thu 7 ngày gần nhất cho biểu đồ
$sql_revenue = "SELECT NgayDat, SUM(TongTienThanhToan) as daily_total 
                FROM qldatve 
                WHERE NgayDat >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                GROUP BY NgayDat 
                ORDER BY NgayDat ASC";
$result_revenue = mysqli_query($conn, $sql_revenue);

$labels = [];
$data_revenue = [];
while ($row = mysqli_fetch_assoc($result_revenue)) {
    $labels[] = date("d/m", strtotime($row['NgayDat']));
    $data_revenue[] = $row['daily_total'];
}

// 2. Lấy Top 3 phim bán chạy nhất (Dựa vào số lần xuất hiện trong bảng qldatve)
$sql_hot_movies = "SELECT p.TenPhim, COUNT(q.IDPhim) as SoVe, SUM(q.TongTienThanhToan) as DoanhThu
                   FROM qldatve q
                   JOIN qlphim p ON q.IDPhim = p.IDPhim
                   GROUP BY q.IDPhim
                   ORDER BY SoVe DESC
                   LIMIT 3";
$result_hot_movies = mysqli_query($conn, $sql_hot_movies);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Chủ - Đặt vé phim</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="formTrangChuNV.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<?php include('../headfoot/headerNV.php'); ?>

<main class="home">

    <h1 class="dashboard-title">Trang chủ nhân viên</h1>

    <?php
    // Tổng số phim
    $phim = $conn->query("SELECT COUNT(*) AS total FROM qlphim")->fetch_assoc();

    // Suất chiếu hôm nay
    $lich = $conn->query("
        SELECT COUNT(*) AS total 
        FROM qllichchieu 
        WHERE NgayChieu = '$today'
    ")->fetch_assoc();

    // Vé đã đặt
    $ve = $conn->query("SELECT COUNT(*) AS total FROM qldatve ")->fetch_assoc();

    //Doanh thu
    $doanhthu = $conn->query("SELECT SUM(tongtienthanhtoan) AS total FROM qldatve")->fetch_assoc();

    // Khách hàng (IDQuyen = khách)
    $khach = $conn->query("
        SELECT COUNT(*) AS total 
        FROM quanlytaikhoan 
        WHERE IDQuyen = 2
    ")->fetch_assoc();

    // Rạp
    $rap = $conn->query("SELECT COUNT(*) AS total FROM rap")->fetch_assoc();

    // Đồ ăn uống
    $douong = $conn->query("SELECT COUNT(*) AS total FROM doanuong")->fetch_assoc();
    ?>

    <div class="dashboard">

        <div class="card">
            <h3>🎬 Số Lượng Phim</h3>
            <p><?= $phim['total'] ?></p>
            
        </div>

        <div class="card">
            <h3>📅 Suất chiếu hôm nay</h3>
            <p><?= $lich['total'] ?></p>

        </div>

        <div class="card">
            <h3>🎟 Vé đã đặt</h3>
            <p><?= $ve['total'] ?></p>

        </div>

        <div class="card">
            <h3>💰 Doanh thu</h3>
            <p>
                <?php 
                    // Tất cả logic xử lý phải nằm trong cặp thẻ này
                    if ($doanhthu['total'] == null) {
                        echo "0";
                    } else {
                        echo number_format($doanhthu['total'], 0, ',', '.') . 'đ';
                    }
                ?>
            </p>

        </div>

        <div class="card">
            <h3>🏢 Số Lượng Rạp</h3>
            <p><?= $rap['total'] ?></p>

        </div>

        <div class="card">
            <h3>🍿 Đồ ăn uống</h3>
            <p><?= $douong['total'] ?></p>

        </div>

    </div>

    <div class="dashboard-lower-section">
        <div class="chart-container">
            <h3>📈 Thống kê doanh thu 7 ngày qua</h3>
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="list-container">
            <h3>🔥 Phim đang bán chạy</h3>
            <table class="hot-movies-table">
                <thead>
                    <tr>
                        <th>Phim</th>
                        <th>Số vé</th>
                        <th>Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($movie = mysqli_fetch_assoc($result_hot_movies)): ?>
                    <tr>
                        <td><?= $movie['TenPhim'] ?></td>
                        <td><span class="badge hot"><?= $movie['SoVe'] ?> vé</span></td>
                        <td><?= number_format($movie['DoanhThu'], 0, ',', '.') ?>đ</td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        // Chuyển mảng PHP thành mảng JavaScript bằng json_encode
        labels: <?php echo json_encode($labels); ?>, 
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: <?php echo json_encode($data_revenue); ?>,
            borderColor: '#ff4d4d',
            backgroundColor: 'rgba(255, 77, 77, 0.2)',
            borderWidth: 2,
            fill: true,
            tension: 0.4 
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { 
                beginAtZero: true,
                ticks: { color: 'white' } 
            },
            x: { ticks: { color: 'white' } }
        },
        plugins: {
            legend: { labels: { color: 'white' } }
        }
    }
});
</script>
</body>

</html>
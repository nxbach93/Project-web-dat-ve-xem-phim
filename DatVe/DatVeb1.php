<?php
session_start();
require_once "../headfoot/connect.php";

// 1. NHẬN ID TỪ URL
$idlc = isset($_GET['idlc']) ? intval($_GET['idlc']) : 0;

if ($idlc <= 0) {
    die("<h3 style='color:white; text-align:center; margin-top:50px;'>⚠ Lỗi: Không tìm thấy mã lịch chiếu!</h3>");
}

// 2. LẤY THÔNG TIN PHIM & RẠP
$sql_info = "SELECT lc.*, p.TenPhim, p.Poster, p.ThoiLuong, r.TenRap, r.DiaChi 
             FROM qllichchieu lc
             JOIN qlphim p ON lc.IDPhim = p.IDPhim
             JOIN rap r ON lc.IDRap = r.IDRap
             WHERE lc.IDLichChieu = ?";

$stmt = $conn->prepare($sql_info);
$stmt->bind_param("i", $idlc);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("<h3 style='color:white; text-align:center;'>Lỗi: Suất chiếu không tồn tại.</h3>");
}

// 3. LẤY GIÁ VÉ
$gia_ve = 75000;
$gia_rs = $conn->query("SELECT GiaNgayThuong FROM thongtinve LIMIT 1");
if ($gia_rs && $row = $gia_rs->fetch_assoc()) {
    $gia_ve = $row['GiaNgayThuong'];
}

$hang_ghe = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt vé: <?= htmlspecialchars($data['TenPhim']) ?></title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link rel="stylesheet" href="DatVe.css">
    <script src="DatVe.js"></script>
</head>
<body>
    <?php include "../headfoot/header.php"; ?>
    <br><br><br>

    <div class="booking-container">
        <div class="seat-selection">
            <div class="legend">
                <div class="item"><span class="seat"></span> Trống</div>
                <div class="item"><span class="seat selected" style="background-color: #e50914;"></span> Đang chọn</div>
                <div class="item"><span class="seat occupied"></span> Đã bán</div>
            </div>

            <div class="screen">MÀN HÌNH</div>
            
            <div class="seat-map">
                <?php foreach ($hang_ghe as $hang): ?>
                    <div class="row">
                        <span class="row-label"><?= $hang ?></span>
                        <?php
                        $sql_ghe = "SELECT * FROM qlghengoi WHERE HangGhe = ? ORDER BY IDGhe ASC";
                        $stmt_ghe = $conn->prepare($sql_ghe);
                        $stmt_ghe->bind_param("s", $hang);
                        $stmt_ghe->execute();
                        $res_ghe = $stmt_ghe->get_result();

                        while ($seat = $res_ghe->fetch_assoc()):
                            $is_sold = ($seat['TrangThai'] == 'DaDat') ? 'occupied' : '';
                        ?>
                            <div class="seat <?= $is_sold ?>" 
                                 data-id="<?= $seat['IDGhe'] ?>" 
                                 data-name="<?= $seat['TenGhe'] ?>"
                                 data-price="<?= $gia_ve ?>">
                                <?= substr($seat['TenGhe'], 1) ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="booking-summary">
            <div class="timer-box">
                <i class="far fa-clock"></i> Thời gian giữ ghế: <span id="countdown">10:00</span>
            </div>

            <div style="text-align: center;">
                <img src="../images/movie/<?= $data['Poster'] ?>" style="width: 120px; border-radius: 5px;">
            </div>
            
            <h2 class="movie-title"><?= htmlspecialchars($data['TenPhim']) ?></h2>
            <div class="info-item">
                <span>Rạp:</span> <strong><?= htmlspecialchars($data['TenRap']) ?></strong>
            </div>
            <div class="info-item">
                <span>Suất chiếu:</span> 
                <strong style="color: #fff;">
                    <?= date('H:i', strtotime($data['GioChieu'])) ?> | <?= date('d/m/Y', strtotime($data['NgayChieu'])) ?>
                </strong>
            </div>
            
            <div class="info-item">
                <span>Ghế chọn:</span> 
                <b id="display-seats" style="color: #e50914;">---</b>
            </div>
            
            <div class="info-item">
                <span>Tổng tiền:</span> 
                <b id="display-price" style="color: #ff3232; font-size: 1.2em;">0 đ</b>
            </div>

            <form action="DatVeb2.php" method="POST" id="bookingForm">
                <input type="hidden" name="idlc" value="<?= $idlc ?>">
                <input type="hidden" name="ds_ghe_id" id="input-ghe-id">
                <input type="hidden" name="ds_ghe_ten" id="input-ghe-ten">
                <input type="hidden" name="tong_tien" id="input-tien">
                
                <button type="submit" class="btn-continue" id="btnNext" disabled>TIẾP TỤC</button>
            </form>
        </div>
    </div>
</body>
</html>
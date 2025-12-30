<?php
require_once '../headfoot/connect.php';
require_once '../Data/PhimData.php';
require_once '../Data/DataRap.php';
require_once '../Data/DataLichChieu.php';

$idLichChieu = $_GET['idlichchieu'] ?? null;
$idPhim      = $_GET['idphim'] ?? null;
$idRap       = $_GET['idrap'] ?? null;
$ngay        = $_GET['ngay'] ?? null;
$gio         = $_GET['gio'] ?? null;

if (!$idLichChieu || !$idPhim || !$idRap) {
    die("Thiếu dữ liệu xác nhận");
}

$dataPhim = new PhimData($conn);
$dataRap  = new DataRap($conn);
$dataLich = new DataLichChieu($conn);

$phim = $dataPhim->getMovieById($idPhim);
$rap  = $dataRap->getById($idRap);

$gheTrong = $dataLich->tinhGheTrong($idLichChieu);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác nhận đặt vé</title>
    <link rel="stylesheet" href="XacNhan.css">
</head>
<body>

<div class="confirm-container">
    <h2 class="title">🎟️ XÁC NHẬN ĐẶT VÉ</h2>

    <div class="movie-box">
        <img
            src="../images/movie/<?= htmlspecialchars($phim['Poster']) ?>"
            alt="<?= htmlspecialchars($phim['TenPhim']) ?>"
        >

        <div class="movie-info">
            <h3><?= htmlspecialchars($phim['TenPhim']) ?></h3>

            <p><strong>Rạp:</strong> <?= htmlspecialchars($rap['TenRap']) ?></p>
            <p><strong>Ngày chiếu:</strong> <?= date('d/m/Y', strtotime($ngay)) ?></p>
            <p><strong>Giờ chiếu:</strong> <?= $gio ?></p>
            <p><strong>Ghế trống:</strong> <?= $gheTrong ?></p>
        </div>
    </div>

    <form action="ThanhToan.php" method="POST">
        <input type="hidden" name="idlichchieu" value="<?= $idLichChieu ?>">
        <input type="hidden" name="idphim" value="<?= $idPhim ?>">
        <input type="hidden" name="idrap" value="<?= $idRap ?>">

        <button type="submit" class="btn-confirm">
            ✅ XÁC NHẬN ĐẶT VÉ
        </button>
    </form>
</div>

</body>
</html>

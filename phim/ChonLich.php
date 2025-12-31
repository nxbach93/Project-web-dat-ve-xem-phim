<?php
require_once '../headfoot/connect.php';
require_once '../Data/DataLichChieu.php';
if (!isset($_GET['idrap']) || !isset($_GET['idphim'])) {
    die("Thiếu thông tin rạp hoặc phim");
}

$idRap  = (int)$_GET['idrap'];
$idPhim = (int)$_GET['idphim'];

$dataLich = new DataLichChieu($conn);

$dsNgay = $dataLich->getDanhSachNgay($idRap, $idPhim);

if (isset($_GET['ngay'])) {
    $ngay = $_GET['ngay'];
} else {
    $ngay = $dsNgay[0]['NgayChieu'] ?? null;
}
$dsLichChieu = [];

if ($ngay !== null) {
    $dsLichChieu = $dataLich->getLichChieuTheoNgay(
        $idRap,
        $idPhim,
        $ngay
    );
}



$sqlPhim = "SELECT * FROM qlphim WHERE IDPhim = ?";
$stmt = $conn->prepare($sqlPhim);
$stmt->bind_param("i", $idPhim);
$stmt->execute();
$result = $stmt->get_result();
$phim = $result->fetch_assoc();

if (!$phim) {
    die("Không tìm thấy phim");
}




?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chọn lịch chiếu</title>
    <link rel="stylesheet" href="ChonLich.css">
</head>
<body>

<div class="container">

    <div class="movie-info">
        <img src="uploads/<?= $phim['Poster'] ?>" alt="">
        <div>
            <h2><?= $phim['TenPhim'] ?></h2>
            <p>Chọn ngày và suất chiếu phù hợp</p>
        </div>
    </div>

    <div class="date-filter">
    <?php foreach ($dsNgay as $d): ?>
        <a
            href="?idrap=<?= $idRap ?>&idphim=<?= $idPhim ?>&ngay=<?= $d['Ngay'] ?>"
            class="date-item <?= ($ngay == $d['Ngay']) ? 'active' : '' ?>"
        >
            <?= date('d/m', strtotime($d['Ngay'])) ?>
        </a>
    <?php endforeach; ?>
</div>
   <div class="showtime-list">
    <?php if (empty($dsLichChieu)): ?>
        <p class="text-muted">Không có suất chiếu cho ngày này.</p>
    <?php endif; ?>

    <?php foreach ($dsLichChieu as $lc): ?>
        <a
            href="XacNhan.php
                ?idlichchieu=<?= $lc['IDLichChieu'] ?>
                &idphim=<?= $idPhim ?>
                &idrap=<?= $idRap ?>
                &ngay=<?= $ngay ?>
                &gio=<?= $lc['GioChieu'] ?>"
            class="showtime-card"
        >
            <div class="time"><?= $lc['GioChieu'] ?></div>
            <div class="rap"><?= $lc['TenRap'] ?></div>
        </a>
    <?php endforeach; ?>
</div>



</div>

</body>
</html>

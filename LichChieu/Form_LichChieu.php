<?php
require "../headfoot/connect.php";

$raps = [];
$rap_rs = $conn->query("SELECT IDRap, TenRap FROM rap ORDER BY IDRap");
while ($r = $rap_rs->fetch_assoc()) $raps[] = $r;

$selectedRap = isset($_GET['rap']) ? intval($_GET['rap']) : $raps[0]['IDRap'];

$currentRapName = '';
foreach ($raps as $r) {
    if ($r['IDRap'] == $selectedRap) {
        $currentRapName = $r['TenRap'];
        break;
    }
}

/* ===== NGÀY ===== */
$ngay_rs = $conn->query("
    SELECT DISTINCT NgayChieu
    FROM qllichchieu
    WHERE IDRap = $selectedRap
    ORDER BY NgayChieu
");

$selectedNgay = $_GET['ngay'] ?? '';
if (empty($selectedNgay) && $ngay_rs->num_rows > 0) {
    $tmp = $ngay_rs->fetch_assoc();
    $selectedNgay = $tmp['NgayChieu'];
    $ngay_rs->data_seek(0);
}

/* ===== PHIM ===== */
$phim_rs = $conn->query("
    SELECT DISTINCT p.IDPhim, p.TenPhim, p.Poster,
                    p.TheLoai, p.ThoiLuong, p.Rate
    FROM qllichchieu lc
    JOIN qlphim p ON lc.IDPhim = p.IDPhim
    WHERE lc.IDRap = $selectedRap
      AND lc.NgayChieu = '$selectedNgay'
");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Lịch chiếu theo rạp</title>

<link rel="stylesheet" href="../headfoot/header.css">
<link rel="stylesheet" href="Form_LichChieu.css">
</head>
<body>

<?php include __DIR__ . "/../headfoot/header.php"; ?>

<div class="container">
    <?php include __DIR__ . "/lichchieu.header.php"; ?>
    <?php include __DIR__ . "/lichchieu.list.php"; ?>
    <?php include __DIR__ . "/lichchieu.modal.php"; ?>
</div>

<script src="lichchieu.js"></script>
</body>
</html>
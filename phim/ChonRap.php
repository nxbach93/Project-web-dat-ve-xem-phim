<?php
require_once '../headfoot/connect.php';
require_once '../Data/DataRap.php';

if (!isset($_GET['idphim'])) {
    die("Thiếu ID phim");
}

$idPhim = (int)$_GET['idphim'];

$dataRap = new DataRap($conn);
$dsRap = $dataRap->getAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chọn rạp</title>
    <link rel="stylesheet" href="ChonRap.css">
</head>
<body>

<h2>🎬 Chọn rạp chiếu</h2>

<div class="rap-list">
    <?php foreach ($dsRap as $rap): ?>
        <a
            class="rap-item"
            href="ChonLich.php?idphim=<?= $idPhim ?>&idrap=<?= $rap['IDRap'] ?>"
        >
            <h4><?= $rap['TenRap'] ?></h4>
            <p><?= $rap['DiaChi'] ?></p>
        </a>
    <?php endforeach; ?>
</div>

</body>
</html>

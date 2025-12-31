<?php
require "../headfoot/connect.php";

$sqlGiaVe = "SELECT IDVe, LoaiVe, GiaNgayThuong, GiaUuDai, GiaNgayLe FROM thongtinve ORDER BY IDVe";
$giaves = $conn->query($sqlGiaVe);

if (!$giaves) {
    die("Lỗi truy vấn bảng thongtinve: " . $conn->error);
}

$sqlDoAn = "SELECT TenDoAnUong, Gia, GiaUuDai FROM doanuong ORDER BY TenDoAnUong";
$rsDoAn = $conn->query($sqlDoAn);
$doanuongs = [];
if ($rsDoAn) {
    while ($row = $rsDoAn->fetch_assoc()) {
        $doanuongs[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bảng Giá Vé & Đồ Ăn</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="giave.css">
</head>
<body>

<?php include "../headfoot/header.php"; ?>
<br><br><br><br>
<div class="container">
    <h1 class="main-title">BẢNG GIÁ DỊCH VỤ</h1>

    <h2>🎟️ THÔNG TIN GIÁ VÉ</h2>
    <table>
        <thead>
            <tr>
                <th>Loại vé</th>
                <th>Giá Ngày thường</th>
                <th>Giá Ưu đãi</th>
                <th>Giá Ngày lễ</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($giaves->num_rows > 0): ?>
            <?php while ($g = $giaves->fetch_assoc()): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($g['LoaiVe']) ?></strong></td>
                    <td class="price"><?= number_format($g['GiaNgayThuong'], 0, ',', '.') ?> đ</td>
                    <td class="price"><?= number_format($g['GiaUuDai'], 0, ',', '.') ?> đ</td>
                    <td class="price"><?= number_format($g['GiaNgayLe'], 0, ',', '.') ?> đ</td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty">Chưa có dữ liệu giá vé trong hệ thống.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <br><br>

    <h2>🍿 DANH MỤC ĐỒ ĂN UỐNG</h2>
    <table>
        <thead>
            <tr>
                <th>Tên Combo / Sản phẩm</th>
                <th>Giá Niêm yết</th>
                <th>Giá Ưu đãi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($doanuongs) > 0): ?>
            <?php foreach ($doanuongs as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['TenDoAnUong']) ?></td>
                <td class="price"><?= number_format($d['Gia'], 0, ',', '.') ?> đ</td>
                <td class="price"><?= number_format($d['GiaUuDai'], 0, ',', '.') ?> đ</td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="empty">Chưa có dữ liệu đồ ăn uống.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
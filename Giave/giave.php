<?php
// ================= KẾT NỐI DATABASE =================
$conn = new mysqli("localhost", "root", "", "testdbproject2");
if ($conn->connect_error) {
    die("Lỗi kết nối DB: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ================= LẤY DANH SÁCH RẠP =================
$raps = [];
$sqlRap = "SELECT IDRap, TenRap FROM rap ORDER BY TenRap";
$rsRap = $conn->query($sqlRap);

while ($row = $rsRap->fetch_assoc()) {
    $raps[] = $row;
}

if (count($raps) == 0) {
    die("Chưa có dữ liệu rạp");
}

// ================= RẠP ĐANG CHỌN =================
$idrap = isset($_GET['idrap']) ? (int)$_GET['idrap'] : $raps[0]['IDRap'];

// ================= LẤY GIÁ VÉ THEO RẠP =================
$stmt = $conn->prepare("
    SELECT LoaiVe, GiaNgayThuong, GiaUuDai, GiaNgayLe
    FROM thongtinve
    WHERE IDRap = ?
    ORDER BY LoaiVe
");
$stmt->bind_param("i", $idrap);
$stmt->execute();
$giaves = $stmt->get_result();

// ================= LẤY DANH SÁCH ĐỒ ĂN UỐNG =================
$sqlDoAn = "SELECT TenDoAnUong, Gia, GiaUuDai FROM doanuong ORDER BY TenDoAnUong";
$rsDoAn = $conn->query($sqlDoAn);
$doanuongs = [];
while ($row = $rsDoAn->fetch_assoc()) {
    $doanuongs[] = $row;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giá vé & Đồ ăn uống</title>
<!-- CSS RIÊNG -->
<link rel="stylesheet" href="giave.css">
</head>
<body>

<div class="container">
    <h2>🎟️ GIÁ VÉ THEO RẠP</h2>

    <!-- ===== CHỌN RẠP ===== -->
    <div class="select-rap">
        <form method="get">
            <label>Chọn rạp:</label>
            <select name="idrap" onchange="this.form.submit()">
                <?php foreach ($raps as $r): ?>
                    <option value="<?= $r['IDRap'] ?>" <?= $r['IDRap'] == $idrap ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['TenRap']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- ===== BẢNG GIÁ VÉ ===== -->
    <table>
        <thead>
            <tr>
                <th>Loại vé</th>
                <th>Ngày thường</th>
                <th>Ưu đãi</th>
                <th>Ngày lễ</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($giaves->num_rows > 0): ?>
            <?php while ($g = $giaves->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($g['LoaiVe']) ?></td>
                    <td class="price"><?= number_format($g['GiaNgayThuong']) ?> đ</td>
                    <td class="price"><?= number_format($g['GiaUuDai']) ?> đ</td>
                    <td class="price"><?= number_format($g['GiaNgayLe']) ?> đ</td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="empty">Chưa có dữ liệu giá vé</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- ===== BẢNG ĐỒ ĂN UỐNG ===== -->
    <h2>🍿 ĐỒ ĂN UỐNG</h2>
    <table>
        <thead>
            <tr>
                <th>Tên đồ ăn</th>
                <th>Giá thường</th>
                <th>Giá ưu đãi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($doanuongs) > 0): ?>
            <?php foreach ($doanuongs as $d): ?>
            <tr>
                <td><?= htmlspecialchars($d['TenDoAnUong']) ?></td>
                <td class="price"><?= number_format($d['Gia']) ?> đ</td>
                <td class="price"><?= number_format($d['GiaUuDai']) ?> đ</td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3" class="empty">Chưa có dữ liệu đồ ăn uống</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>

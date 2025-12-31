<?php
require_once '../../headfoot/connect.php';
require_once '../../Data/PhimData.php';
session_start();


if (!isset($_SESSION['LoaiTK'])) {
    header("Location: ../login.php");
    exit();
}


if (!in_array($_SESSION['LoaiTK'], ['admin', 'staff'])) {
    echo "❌ Bạn không có quyền thêm phim";
    exit();
}

$error = null;
$dataPhim = new PhimData($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = "../../images/movie/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $posterName = time() . '_' . basename($_FILES['Poster']['name']);
    $uploadPath = $uploadDir . $posterName;

    if (!move_uploaded_file($_FILES['Poster']['tmp_name'], $uploadPath)) {
        $error = "❌ Upload poster thất bại";
    }

    if (!$error) {
        $data = [
            'TenPhim'        => $_POST['TenPhim'],
            'ThoiLuong'      => (int)$_POST['ThoiLuong'],
            'TheLoai'        => $_POST['TheLoai'],
            'QuocGia'        => $_POST['QuocGia'],
            'NgayKhoiChieu'  => $_POST['NgayKhoiChieu'],
            'Poster'         => $posterName,
            'DaoDien'        => $_POST['DaoDien'],
            'DienVien'       => $_POST['DienVien'],
            'TomTat'         => $_POST['TomTat'],
            'Rate'           => $_POST['Rate'] ?? 0,
            'TongGhe'        => 100
        ];

        if ($dataPhim->addMovie($data)) {
            header("Location: phimAdmin.php");
            exit();
        } else {
            $error = "❌ Thêm phim thất bại";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm phim</title>

    <link rel="stylesheet" href="../../headfoot/headerNV.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../../headfoot/header.php"; ?>

<div class="container mt-4">
    <h2>➕ Thêm phim mới</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Tên phim</label>
            <input type="text" name="TenPhim" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Thể loại</label>
            <input type="text" name="TheLoai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Quốc gia</label>
            <input type="text" name="QuocGia" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Ngày khởi chiếu</label>
            <input type="date" name="NgayKhoiChieu" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Thời lượng (phút)</label>
            <input type="number" name="Thoiluong" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Đạo diễn</label>
            <input type="text" name="DaoDien" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Diễn viên</label>
            <input type="text" name="DienVien" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Poster phim</label>
            <input type="file" name="Poster" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Đánh giá (0–10)</label>
            <input type="number" name="Rate" step="0.1" min="0" max="10" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tóm tắt phim</label>
            <textarea name="TomTat" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-success">Lưu phim</button>
        <a href="phimAdmin.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

</body>
</html>

<?php
require_once '../../headfoot/connect.php';
session_start();

/* ================= CHECK LOGIN ================= */
if (!isset($_SESSION['LoaiTK'])) {
    header("Location: ../login.php");
    exit();
}

/* ================= CHECK QUYỀN ================= */
/* admin + staff được thêm phim */
if (!in_array($_SESSION['LoaiTK'], ['admin', 'staff'])) {
    echo "❌ Bạn không có quyền thêm phim";
    exit();
}

$error = null;

/* ================= XỬ LÝ FORM ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ===== LẤY DATA ===== */
    $tenPhim     = $_POST['TenPhim'];
    $theLoai     = $_POST['TheLoai'];
    $quocGia     = $_POST['QuocGia'];
    $thoiLuong   = (int)$_POST['ThoiLuong'];
    $ngayKC      = $_POST['NgayKhoiChieu'];
    $daoDien     = $_POST['DaoDien'];
    $dienVien    = $_POST['DienVien'];
    $tomTat      = $_POST['TomTat'];
    $rate        = $_POST['Rate'];

    /* ===== UPLOAD POSTER ===== */
    $posterName = time() . '_' . basename($_FILES['Poster']['name']);
    $uploadDir  = "../../images/movie/";
    $uploadPath = $uploadDir . $posterName;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['Poster']['tmp_name'], $uploadPath)) {
        $error = "❌ Upload poster thất bại";
    }

    /* ===== INSERT DB ===== */
    if (!$error) {
        $sql = "
            INSERT INTO qlphim (
                TenPhim, TheLoai, QuocGia,
                ThoiLuong, NgayKhoiChieu,
                Poster, DaoDien, DienVien,
                TomTat, Rate, Comment
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL)
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssisssssi",
            $tenPhim,
            $theLoai,
            $quocGia,
            $thoiLuong,
            $ngayKC,
            $posterName,
            $daoDien,
            $dienVien,
            $tomTat,
            $rate
        );
        $stmt->execute();

        header("Location: phimAdmin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm phim</title>

    <link rel="stylesheet" href="../../headfoot/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../../headfoot/header.php"; ?>

<div class="container mt-4">
    <h2>➕ Thêm phim mới</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- FORM -->
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
            <input type="number" name="ThoiLuong" class="form-control" required>
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

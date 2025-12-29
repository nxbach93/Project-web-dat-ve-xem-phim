<?php
require_once '../../headfoot/connect.php';
require_once '../../Data/PhimData.php';
session_start();

/* ================= CHECK LOGIN ================= */
if (!isset($_SESSION['LoaiTK'])) {
    header("Location: ../login.php");
    exit();
}

/* ================= CHECK QUYỀN ================= */
if (!in_array($_SESSION['LoaiTK'], ['admin', 'staff'])) {
    echo "❌ Bạn không có quyền sửa phim";
    exit();
}

$phimData = new PhimData($conn);

/* ================= CHECK ID ================= */
if (!isset($_GET['id'])) {
    header("Location: phimAdmin.php");
    exit();
}

$id = (int)$_GET['id'];

/* ================= LẤY PHIM ================= */
$movie = $phimData->getMovieById($id);
if (!$movie) {
    header("Location: phimAdmin.php");
    exit();
}

$error = null;

/* ================= UPDATE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ===== LẤY DATA ===== */
    $data = [
        'TenPhim'       => $_POST['TenPhim'],
        'ThoiLuong'     => (int)$_POST['ThoiLuong'],
        'TheLoai'       => $_POST['TheLoai'],
        'QuocGia'       => $_POST['QuocGia'],
        'NgayKhoiChieu' => $_POST['NgayKhoiChieu'],
        'DaoDien'       => $_POST['DaoDien'],
        'DienVien'      => $_POST['DienVien'],
        'TomTat'        => $_POST['TomTat'],
        'Rate'          => $_POST['Rate'],
        'TongGhe'       => $movie['TongGhe'], // giữ nguyên
        'Poster'        => $movie['Poster']
    ];

    /* ===== XỬ LÝ POSTER ===== */
    if (!empty($_FILES['Poster']['name'])) {

        $posterName = time() . '_' . basename($_FILES['Poster']['name']);
        $uploadDir  = "../../images/movie/";
        $uploadPath = $uploadDir . $posterName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['Poster']['tmp_name'], $uploadPath)) {

            // xóa poster cũ
            $oldPath = $uploadDir . $movie['Poster'];
            if (!empty($movie['Poster']) && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $data['Poster'] = $posterName;
        } else {
            $error = "❌ Upload poster mới thất bại";
        }
    }

    /* ===== UPDATE DB QUA DATA ===== */
    if (!$error) {
        $phimData->updateMovie($id, $data);
        header("Location: phimAdmin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa phim</title>

    <link rel="stylesheet" href="../../headfoot/headerNV.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include "../../headfoot/header.php"; ?>

<div class="container mt-4">
    <h2>✏️ Sửa phim</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Tên phim</label>
            <input type="text" name="TenPhim" class="form-control"
                   value="<?= htmlspecialchars($movie['TenPhim']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Thể loại</label>
            <input type="text" name="TheLoai" class="form-control"
                   value="<?= htmlspecialchars($movie['TheLoai']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Quốc gia</label>
            <input type="text" name="QuocGia" class="form-control"
                   value="<?= htmlspecialchars($movie['QuocGia']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Ngày khởi chiếu</label>
            <input type="date" name="NgayKhoiChieu" class="form-control"
                   value="<?= $movie['NgayKhoiChieu'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Thời lượng (phút)</label>
            <input type="number" name="ThoiLuong" class="form-control"
                   value="<?= $movie['ThoiLuong'] ?>" required>
        </div>

        <div class="mb-3">
            <label>Poster hiện tại</label><br>
            <img src="../../images/movie/<?= htmlspecialchars($movie['Poster']) ?>"
                 style="max-width:140px;border-radius:10px">
        </div>

        <div class="mb-3">
            <label>Đổi poster (nếu cần)</label>
            <input type="file" name="Poster" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label>Đạo diễn</label>
            <input type="text" name="DaoDien" class="form-control"
                   value="<?= htmlspecialchars($movie['DaoDien']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Diễn viên</label>
            <input type="text" name="DienVien" class="form-control"
                   value="<?= htmlspecialchars($movie['DienVien']) ?>" required>
        </div>

        <div class="mb-3">
            <label>Đánh giá</label>
            <input type="number" step="0.1" min="0" max="10"
                   name="Rate" class="form-control"
                   value="<?= $movie['Rate'] ?>">
        </div>

        <div class="mb-3">
            <label>Tóm tắt phim</label>
            <textarea name="TomTat" class="form-control" rows="4" required><?= 
                htmlspecialchars($movie['TomTat']) 
            ?></textarea>
        </div>

        <button class="btn btn-primary">Lưu thay đổi</button>
        <a href="phimAdmin.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

</body>
</html>

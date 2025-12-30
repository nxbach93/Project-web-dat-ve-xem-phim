<?php
session_start();
include '../DangNhap/db.php';

// 1. Kiểm tra quyền
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    die("Bạn không có quyền truy cập trang này.");
}

// 2. Kiểm tra ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tin tức không hợp lệ.");
}
$id = (int)$_GET['id'];

// 3. Xử lý khi bấm nút Cập nhật (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieu_de = $_POST['tieu_de'];
    $mo_ta = $_POST['mo_ta'];
    $noi_dung = $_POST['noi_dung'];
    
    // Mặc định giữ nguyên ảnh cũ
    $hinh_anh = $_POST['hinh_anh_cu'];

    // Nếu người dùng chọn ảnh mới
    if (isset($_FILES['hinh_anh_moi']) && $_FILES['hinh_anh_moi']['error'] == 0) {
        $target_dir = "../Image/";
        $file_name = basename($_FILES["hinh_anh_moi"]["name"]);
        $target_file = $target_dir . $file_name;
        
        // Kiểm tra file ảnh
        $check = getimagesize($_FILES["hinh_anh_moi"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["hinh_anh_moi"]["tmp_name"], $target_file)) {
                $hinh_anh = $target_file; // Cập nhật đường dẫn mới
            } else {
                echo "<script>alert('Lỗi khi tải ảnh lên server.');</script>";
            }
        } else {
            echo "<script>alert('File không phải là ảnh.');</script>";
        }
    }

    // Cập nhật Database
    $sql_update = "UPDATE tintuc SET tieu_de=?, mo_ta=?, noi_dung=?, hinh_anh=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("ssssi", $tieu_de, $mo_ta, $noi_dung, $hinh_anh, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href='chiTietTin.php?id=$id';</script>";
    } else {
        echo "<script>alert('Lỗi: " . $stmt->error . "');</script>";
    }
}

// 4. Lấy dữ liệu hiện tại để điền vào form
$stmt = $conn->prepare("SELECT * FROM tintuc WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$tin = $result->fetch_assoc();

if (!$tin) die("Không tìm thấy tin tức.");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Tin Tức</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="suaTin.css">
</head>
<body>

<?php include "../headfoot/header.php"; ?>

<main class="admin-container">
    <div class="admin-header">
        <h2>Sửa Tin Tức: #<?= $id ?></h2>
        <a href="chiTietTin.php?id=<?= $id ?>" class="btn-submit" style="background-color: #555;">Hủy bỏ</a>
    </div>

    <div class="admin-form">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tiêu đề:</label>
                <input type="text" name="tieu_de" class="form-control" value="<?= htmlspecialchars($tin['tieu_de']) ?>" required>
            </div>
            
            <div class="form-group">
                <label>Hình ảnh hiện tại:</label>
                <img src="<?= htmlspecialchars($tin['hinh_anh']) ?>" style="height: 100px; margin-bottom: 10px; border-radius: 4px;">
                <input type="hidden" name="hinh_anh_cu" value="<?= htmlspecialchars($tin['hinh_anh']) ?>">
                
                <label>Chọn ảnh mới (nếu muốn thay đổi):</label>
                <input type="file" name="hinh_anh_moi" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label>Mô tả ngắn:</label>
                <textarea name="mo_ta" class="form-control" style="height: 80px;" required><?= htmlspecialchars($tin['mo_ta']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Nội dung chi tiết:</label>
                <textarea name="noi_dung" class="form-control" style="height: 300px;" required><?= htmlspecialchars($tin['noi_dung']) ?></textarea>
            </div>

            <button type="submit" class="btn-submit">Cập nhật tin tức</button>
        </form>
    </div>
</main>
</body>
</html>
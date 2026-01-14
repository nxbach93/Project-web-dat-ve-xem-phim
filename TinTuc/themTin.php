<?php
session_start();
include '../DangNhap/db.php';

// Xử lý khi bấm nút Lưu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tieu_de = $_POST['tieu_de'];
    $mo_ta = $_POST['mo_ta'];
    $noi_dung = $_POST['noi_dung'];
    
    // --- XỬ LÝ UPLOAD ẢNH ---
    $target_dir = "../Image/"; // Thư mục lưu ảnh
    // Sử dụng tên file gốc
    $file_name = basename($_FILES["hinh_anh"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    
    // Kiểm tra xem có phải file ảnh không
    $check = getimagesize($_FILES["hinh_anh"]["tmp_name"]);
    if($check === false) {
        echo "<script>alert('File không phải là ảnh.');</script>";
        $uploadOk = 0;
    }

    // Nếu mọi thứ ổn, tiến hành upload và lưu vào DB
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file)) {
            // Upload thành công -> Lưu đường dẫn vào Database
            // Đường dẫn lưu trong DB sẽ là: ../Image/ten_file.jpg
            
            $sql = "INSERT INTO tintuc (tieu_de, mo_ta, noi_dung, hinh_anh) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $tieu_de, $mo_ta, $noi_dung, $target_file);
            
            if ($stmt->execute()) {
                echo "<script>alert('Thêm tin mới thành công!'); window.location.href='formTinTucNV.php';</script>";
            } else {
                echo "<script>alert('Lỗi Database: " . $stmt->error . "');</script>";
            }
        } else {
            echo "<script>alert('Xin lỗi, đã có lỗi khi upload file ảnh.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm Tin Tức Mới</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="themTin.css">
</head>
<body>

<?php include "../headfoot/headerNV.php"; ?>

<main class="admin-container">
    <div class="admin-header">
        <h2>Thêm Tin Tức Mới</h2>
        <a href="formTinTucNV.php" class="btn-submit" style="background-color: #555;">Quay lại</a>
    </div>

    <div class="admin-form">
        <!-- enctype="multipart/form-data" là BẮT BUỘC để upload file -->
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tiêu đề:</label>
                <input type="text" name="tieu_de" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Hình ảnh đại diện:</label>
                <!-- Input type="file" để chọn ảnh -->
                <input type="file" name="hinh_anh" class="form-control" required accept="image/*">
            </div>

            <div class="form-group">
                <label>Mô tả ngắn:</label>
                <textarea name="mo_ta" class="form-control" style="height: 80px;" required></textarea>
            </div>

            <div class="form-group">
                <label>Nội dung chi tiết:</label>
                <textarea name="noi_dung" class="form-control" style="height: 200px;" required></textarea>
            </div>

            <button type="submit" class="btn-submit">Lưu Tin Tức</button>
        </form>
    </div>
</main>

</body>
</html>
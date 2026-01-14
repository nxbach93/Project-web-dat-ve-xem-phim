<?php
session_start();
include('../headfoot/connect.php');

// Kiểm tra tham số user trên URL
if (!isset($_GET['user'])) {
    echo "<script>alert('Không tìm thấy nhân viên!'); window.location.href='formTrangChuAdmin.php';</script>";
    exit();
}

$username = $_GET['user'];

// Xử lý cập nhật khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoTen = $_POST['ho_ten'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $ngaySinh = $_POST['ngay_sinh'];
    $gioiTinh = $_POST['gioi_tinh'];
    $diaChi = $_POST['dia_chi'];

    // Cập nhật thông tin (Không cho phép sửa Tên đăng nhập)
    // IDQuyen=2 đảm bảo chỉ update đúng tài khoản nhân viên
    $sql = "UPDATE quanlytaikhoan SET HoVaTen=?, Email=?, SDT=?, NgaySinh=?, GioiTinh=?, DiaChi=? WHERE TenDangNhap=? AND IDQuyen=2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $hoTen, $email, $sdt, $ngaySinh, $gioiTinh, $diaChi, $username);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thông tin nhân viên thành công!'); window.location.href='formTrangChuAdmin.php';</script>";
    } else {
        echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
    }
}

// Lấy thông tin nhân viên hiện tại để điền vào form
$sqlInfo = "SELECT * FROM quanlytaikhoan WHERE TenDangNhap = ? AND IDQuyen = 2";
$stmtInfo = $conn->prepare($sqlInfo);
$stmtInfo->bind_param("s", $username);
$stmtInfo->execute();
$resultInfo = $stmtInfo->get_result();
$nv = $resultInfo->fetch_assoc();

if (!$nv) {
    echo "<script>alert('Nhân viên không tồn tại hoặc không phải quyền Nhân viên!'); window.location.href='formTrangChuAdmin.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa thông tin nhân viên</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="formSuaNhanVien.css">
</head>
<body>

<?php include('../headfoot/headerAdmin.php'); ?>

<main class="admin-container">
    <div class="form-card">
        <h2>Sửa thông tin nhân viên: <?= htmlspecialchars($username) ?></h2>
        
        <form method="POST">
            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" name="ho_ten" value="<?= htmlspecialchars($nv['HoVaTen']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($nv['Email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" value="<?= htmlspecialchars($nv['SDT']) ?>" required>
            </div>

            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="date" name="ngay_sinh" value="<?= htmlspecialchars($nv['NgaySinh']) ?>" required>
            </div>

            <div class="form-group">
                <label>Giới tính</label>
                <select name="gioi_tinh">
                    <option value="Nam" <?= ($nv['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                    <option value="Nữ" <?= ($nv['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                    <option value="Khác" <?= ($nv['GioiTinh'] == 'Khác') ? 'selected' : '' ?>>Khác</option>
                </select>
            </div>

            <div class="form-group">
                <label>Địa chỉ</label>
                <input type="text" name="dia_chi" value="<?= htmlspecialchars($nv['DiaChi']) ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Cập nhật</button>
                <a href="formTrangChuAdmin.php" class="btn-cancel">Hủy bỏ</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
<?php
session_start();
include('../headfoot/connect.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../DangNhap/formDangNhap.php");
    exit();
}

$user = $_SESSION['username'];

// Xử lý đổi mật khẩu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass_old = $_POST['old_password'];
    $pass_new = $_POST['new_password'];
    $pass_confirm = $_POST['confirm_password'];

    // Kiểm tra mật khẩu cũ
    $sql_check = "SELECT MatKhau FROM quanlytaikhoan WHERE TenDangNhap='$user'";
    $result = mysqli_query($conn, $sql_check);
    $row = mysqli_fetch_assoc($result);

    if ($row['MatKhau'] !== $pass_old) {
        echo "<script>alert('Mật khẩu cũ không đúng');</script>";
    } elseif ($pass_new !== $pass_confirm) {
        echo "<script>alert('Mật khẩu xác nhận không khớp');</script>";
    } else {
        $sql_update = "UPDATE quanlytaikhoan SET MatKhau='$pass_new' WHERE TenDangNhap='$user'";
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.'); window.location.href='../DangNhap/logout.php';</script>";
        } else {
            echo "<script>alert('Lỗi: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DoiMK.css">
    <script src="DoiMK.js"></script>
    <title>Đổi mật khẩu Admin</title>
</head>
<body>
    <?php include "../headfoot/headerAdmin.php"; ?>
    <br><br><br><br><br><br>
    <div class="password-container">
        <div class="password-card">
            <h2 class="form-title">Đổi mật khẩu</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Mật khẩu cũ</label>
                    <input type="password" name="old_password" placeholder="Nhập mật khẩu cũ" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" required>
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-update">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
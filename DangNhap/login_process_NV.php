<?php
session_start();
include "db.php";

$user = $_POST['username'];
$pass = $_POST['password'];

$sql = "SELECT * FROM quanlytaikhoan WHERE TenDangNhap='$user' AND MatKhau='$pass'";
$result = mysqli_query($conn, $sql);

// Kiểm tra: Nếu đúng tài khoản mật khẩu VÀ phải có IDQuyen = 3
if (mysqli_num_rows($result) === 1) {
    $data = mysqli_fetch_assoc($result);
    
    if ($data['IDQuyen'] == 2) {
        $_SESSION['username'] = $user;
        $_SESSION['user_id']  = $data['IDTK'];
        $_SESSION['role']     = 'customer';
        echo "<script>alert('Đăng nhập thành công!'); window.location.assign('../TrangChu/formTrangChuNV.php');</script>";
        exit();
    }
}

// Nếu sai tài khoản hoặc sai quyền (là Admin/NV nhưng login ở đây)
header("Location: formDangNhapNV.php?error=1");
exit();
?>
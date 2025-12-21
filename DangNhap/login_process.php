<?php
session_start();
include "db.php";

$user = $_POST['username'];
$pass = $_POST['password'];
$role = $_POST['role'];

$sql = "
SELECT tk.TenDangNhap, tk.IDQuyen, q.LoaiTK
FROM quanlytaikhoan tk
JOIN qlquyen q ON tk.IDQuyen = q.IDQuyen
WHERE tk.TenDangNhap='$user' AND tk.MatKhau='$pass'
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    if ($role === 'staff') {
        header("Location: formDangNhapNV.php?error=1");
    } else {
        header("Location: formDangNhapKH.php?error=1");
    }
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($role === 'customer' && $data['IDQuyen'] == 1) {
    $_SESSION['username'] = $user;
    echo "<script>alert('Đăng nhập khách hàng thành công'); window.location.href='formTrangChu.php';</script>";
}
elseif ($role === 'staff' && $data['IDQuyen'] == 2) {
    $_SESSION['username'] = $user;
    echo "<script>alert('Đăng nhập nhân viên thành công'); window.location.href='formTrangChu.php';</script>";
}
elseif ($data['IDQuyen'] == 3) {
    $_SESSION['username'] = $user;
    $_SESSION['role'] = 'admin';
    echo "<script>alert('Đăng nhập Admin thành công'); window.location.href='formTrangChu.php';</script>";
}
else {
    echo "<script>alert('Không đúng quyền truy cập'); window.history.back();</script>";
}
?>

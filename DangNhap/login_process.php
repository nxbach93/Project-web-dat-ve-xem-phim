<?php
session_start();
include "db.php";

$user = $_POST['username'];
$pass = $_POST['password'];
$role = $_POST['role'] ?? '';

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
        header("Location: formDangNhap.php?error=1");
    }
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($data['IDQuyen'] == 1) {
    $_SESSION['username'] = $user;
    $_SESSION['role'] = 'customer';
    echo "<script>alert('Đăng nhập khách hàng thành công'); window.location.href='../TrangChu/formTrangChu.php';</script>";
}
elseif ($data['IDQuyen'] == 2) {
    $_SESSION['username'] = $user;
    $_SESSION['role'] = 'employee';
    echo "<script>alert('Đăng nhập nhân viên thành công'); window.location.href='../TrangChu/formTrangChuNV.php';</script>";
}
elseif ($data['IDQuyen'] == 3) {
    $_SESSION['username'] = $user;
    $_SESSION['role'] = 'admin';
    echo "<script>alert('Đăng nhập Admin thành công'); window.location.href='../TrangChu/formTrangChuAdmin.php';</script>";
}

?>

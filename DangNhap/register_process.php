<?php
include "../headfoot/connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* kiểm tra submit */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<script>alert('Không được truy cập trực tiếp file này'); window.location.href='formDangKy.php';</script>";
    exit();
}

/* lấy dữ liệu – có kiểm tra */
$ho_ten = $_POST['ho_ten'] ?? '';
$email  = $_POST['email'] ?? '';
$sdt    = $_POST['so_dien_thoai'] ?? '';
$ns     = $_POST['ngay_sinh'] ?? '';
$gt     = $_POST['gioi_tinh'] ?? '';
$dc     = $_POST['dia_chi'] ?? '';
$user   = $_POST['username'] ?? '';
$pass   = $_POST['password'] ?? '';

if (
    $ho_ten == '' || $email == '' || $sdt == '' ||
    $ns == '' || $gt == '' || $dc == '' ||
    $user == '' || $pass == ''
) {
    echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.history.back();</script>";
    exit();
}

/* kiểm tra trùng username */
$sql_check = "SELECT IDTK FROM quanlytaikhoan WHERE TenDangNhap='$user'";
$result_check = mysqli_query($conn, $sql_check);

if (!$result_check) {
    echo "<script>alert('❌ Lỗi SQL check: " . mysqli_error($conn) . "'); window.history.back();</script>";
    exit();
}

if (mysqli_num_rows($result_check) > 0) {
    echo "<script>alert('Tên đăng nhập đã tồn tại'); window.history.back();</script>";
    exit();
}

/* insert */
$sql_insert = "
INSERT INTO quanlytaikhoan
(TenDangNhap, MatKhau, HoVaTen, Email, SDT, NgaySinh, GioiTinh, DiaChi, DiemThanhVien, IDQuyen)
VALUES
('$user','$pass','$ho_ten','$email','$sdt','$ns','$gt','$dc', 0, 1)
";

if (mysqli_query($conn, $sql_insert)) {
    echo "<script>alert('✅ Đăng ký thành công'); window.location.href='formDangNhap.php';</script>";
} else {
    echo "<script>alert('Lỗi đăng ký: " . mysqli_error($conn) . "'); window.history.back();</script>";
}
?>

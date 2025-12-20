<?php
include "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";

/* kiểm tra submit */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Không được truy cập trực tiếp file này");
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
    die("❌ Vui lòng nhập đầy đủ thông tin");
}

/* kiểm tra trùng username */
$sql_check = "SELECT id_tai_khoan FROM QLTK WHERE username='$user'";
$result_check = mysqli_query($conn, $sql_check);

if (!$result_check) {
    die("❌ Lỗi SQL check: " . mysqli_error($conn));
}

if (mysqli_num_rows($result_check) > 0) {
    die("❌ Tên đăng nhập đã tồn tại");
}

/* insert */
$sql_insert = "
INSERT INTO QLTK
(username, password, ho_ten, email, so_dien_thoai, ngay_sinh, gioi_tinh, dia_chi, id_permission)
VALUES
('$user','$pass','$ho_ten','$email','$sdt','$ns','$gt','$dc',2)
";

if (mysqli_query($conn, $sql_insert)) {
    echo "✅ Đăng ký thành công.<br>";
    echo "<a href='formDangNhapKH.php'>Quay lại đăng nhập</a>";
} else {
    echo "❌ Lỗi INSERT: " . mysqli_error($conn);
}
?>

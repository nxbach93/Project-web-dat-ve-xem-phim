<?php
session_start();
include "db.php";

$user = $_POST['username'];
$pass = $_POST['password'];
$role = $_POST['role'];

$sql = "
SELECT QLTK.username, QLQuyen.quyen
FROM QLTK
JOIN QLQuyen ON QLTK.id_permission = QLQuyen.id_permission
WHERE QLTK.username='$user' AND QLTK.password='$pass'
";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) !== 1) {
    echo "❌ Sai tài khoản hoặc mật khẩu";
    exit();
}

$data = mysqli_fetch_assoc($result);

if ($role === 'staff' && $data['quyen'] == 1) {
    $_SESSION['user'] = $user;
    echo "✅ Đăng nhập nhân viên thành công";
} 
elseif ($role === 'customer' && $data['quyen'] == 0) {
    $_SESSION['user'] = $user;
    echo "✅ Đăng nhập khách hàng thành công";
} 
else {
    echo "❌ Không đúng quyền truy cập";
}
?>

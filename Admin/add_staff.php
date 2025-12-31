<?php
session_start();
require_once '../headfoot/connect.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username  = trim($_POST['username']);
    $password  = trim($_POST['password']);
    $hoten     = trim($_POST['hoten']);
    $email     = trim($_POST['email']);
    $sdt       = trim($_POST['sdt']);
    $ngaysinh  = $_POST['ngaysinh'];
    $gioitinh  = $_POST['gioitinh'];
    $diachi    = trim($_POST['diachi']);


    $check = $conn->prepare("SELECT IDTK FROM quanlytaikhoan WHERE TenDangNhap = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại!";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO quanlytaikhoan
            (TenDangNhap, MatKhau, HoVaTen, Email, SDT, NgaySinh, GioiTinh, DiaChi, DiemThanhVien, IDQuyen)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 3)
        ");

        $stmt->bind_param(
            "ssssssss",
            $username,
            $password,
            $hoten,
            $email,
            $sdt,
            $ngaysinh,
            $gioitinh,
            $diachi
        );

        if ($stmt->execute()) {
            $success = "Tạo tài khoản STAFF thành công!";
        } else {
            $error = "Lỗi khi tạo tài khoản!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo tài khoản Staff</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="add_staff.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include "../headfoot/header.php"; ?>

<div class="container mt-5" style="max-width:600px">
    <h3 class="mb-4 text-center">➕ Tạo tài khoản STAFF</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form  method="post">
        <div class="mb-3">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Họ và tên</label>
            <input type="text" name="hoten" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>SĐT</label>
            <input type="text" name="sdt" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Ngày sinh</label>
            <input type="date" name="ngaysinh" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Giới tính</label>
            <select name="gioitinh" class="form-select">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="diachi" class="form-control" required>
        </div>

        <button type="submit">Tạo tài khoản STAFF</button>
    </form>
</div>

</body>
</html>

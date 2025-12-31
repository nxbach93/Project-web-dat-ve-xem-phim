<?php
session_start();
require_once '../headfoot/connect.php';


$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("
        SELECT tk.IDTK, tk.MatKhau, q.LoaiTK
        FROM quanlytaikhoan tk
        JOIN qlquyen q ON tk.IDQuyen = q.IDQuyen
        WHERE tk.TenDangNhap = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $error = "Tài khoản không tồn tại!";
    } elseif ($password !== $user['MatKhau']) {
        $error = "Sai mật khẩu!";
    } else {

        $_SESSION['IDTK']  = $user['IDTK'];
        $_SESSION['role']  = $user['LoaiTK'];
        $_SESSION['login'] = true;

        if ($user['LoaiTK'] === 'admin') {
            header("Location: add_staff.php");
        } elseif ($user['LoaiTK'] === 'staff') {
            header("Location: ../Staff/phim_admin/phimAdmin.php");
        } else {
            header("Location: ../phim/phim.php");
        }
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="text-center mb-4">🔐 Đăng nhập</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label>Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-danger w-100">Đăng nhập</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

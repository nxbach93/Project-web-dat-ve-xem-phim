<?php
session_start();
require_once '../../headfoot/connect.php';

$error = null;

/* ================= XỬ LÝ LOGIN ================= */
if (isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $error = "Vui lòng nhập đầy đủ thông tin";
    } else {

        /* ===== LẤY USER + QUYỀN ===== */
        $sql = "
            SELECT 
                tk.IDTK,
                tk.TenDangNhap,
                tk.MatKhau,
                tk.HoVaTen,
                q.LoaiTK
            FROM quanlytaikhoan tk
            JOIN qlquyen q ON tk.IDQuyen = q.IDQuyen
            WHERE tk.TenDangNhap = ?
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            /* ===== CHECK PASSWORD ===== */
            // Hiện tại dùng plain text cho đúng schema
            if ($password === $user['MatKhau']) {

                /* ===== LƯU SESSION ===== */
                $_SESSION['IDTK'] = $user['IDTK'];
                $_SESSION['TenDangNhap'] = $user['TenDangNhap'];
                $_SESSION['HoVaTen'] = $user['HoVaTen'];
                $_SESSION['LoaiTK'] = $user['LoaiTK']; // admin | staff | user

                /* ===== PHÂN LUỒNG ===== */
                if (in_array($user['LoaiTK'], ['admin', 'staff'])) {
                    header("Location: phimAdmin.php");
                } else {
                    header("Location: ../phim/phim.php"); // trang xem phim user
                }
                exit();

            } else {
                $error = "❌ Sai mật khẩu";
            }
        } else {
            $error = "❌ Tài khoản không tồn tại";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-body">

                    <h3 class="card-title mb-3 text-center">Đăng nhập</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" name="login" class="btn btn-primary w-100">
                            Đăng nhập
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>

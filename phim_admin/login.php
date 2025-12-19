<?php
session_start();
require_once '../headfoot/connect.php';

// Xử lý đăng nhập
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Lấy user từ database
    $stmt = $conn->prepare("SELECT u.userid, u.user_password, ur.role_id, r.name AS role_name 
                            FROM users u
                            INNER JOIN user_role ur ON u.userid = ur.userid
                            INNER JOIN roles r ON ur.role_id = r.role_id
                            WHERE u.user_name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Kiểm tra mật khẩu (trong ví dụ này là chuỗi thẳng, thực tế nên dùng password_hash)
        if ($password === $user['user_password']) {
            // Kiểm tra role admin
            if ($user['role_name'] === 'admin') {
                $_SESSION['userid'] = $user['userid'];
                $_SESSION['username'] = $username;
                $_SESSION['role'] = 'admin';
                header("Location: phimAdmin.php");
                exit();
            } else {
                $error = "Bạn không có quyền truy cập admin.";
            }
        } else {
            $error = "Sai mật khẩu.";
        }
    } else {
        $error = "Tài khoản không tồn tại.";
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
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title mb-3 text-center">Admin Login</h3>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

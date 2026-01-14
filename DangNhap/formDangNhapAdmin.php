<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link rel="stylesheet" href="formDangNhapAdmin.css">
</head>
<body>

<h2>Đăng nhập Admin</h2>

<form method="post" action="login_process_Admin.php">
    <input type="hidden" name="role" value="customer">

    <label>Tên đăng nhập</label><br>
    <input type="text" name="username" required><br><br>

    <label>Mật khẩu</label><br>
    <input type="password" name="password" required>
    <?php if (isset($_GET['error'])): ?>
        <p style="color: #e50914; margin: -10px 0 15px 0; font-size: 14px;">❌ Sai tài khoản hoặc mật khẩu</p>
    <?php else: ?>
        <br><br>
    <?php endif; ?>

    <button type="submit">Đăng nhập</button>
</form>

</body>
</html>

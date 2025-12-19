<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập nhân viên</title>
</head>
<body>

<h2>Đăng nhập nhân viên</h2>

<form method="post" action="login_process.php">
    <input type="hidden" name="role" value="staff">

    <label>Tên đăng nhập</label><br>
    <input type="text" name="username" required><br><br>

    <label>Mật khẩu</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Đăng nhập</button>
</form>

</body>
</html>

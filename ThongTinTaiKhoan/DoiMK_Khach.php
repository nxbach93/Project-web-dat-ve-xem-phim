<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DoiMK.css">
    <script src="DoiMK.js"></script>
    <title>Đổi mật khẩu</title>
</head>
<body>
    <?php include "../headfoot/header.php"; ?>
    <br><br><br><br><br><br>
    <div class="password-container">
    <div class="password-card">
        <h2 class="form-title">Đổi mật khẩu</h2>
        
        <form action="process-change-password.php" method="POST">
            <div class="form-group">
                <label for="old_password">Mật khẩu cũ</label>
                <input type="password" id="old_password" name="old_password" placeholder="Nhập mật khẩu cũ" required>
            </div>

            <div class="form-group">
                <label for="new_password">Mật khẩu mới</label>
                <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu mới</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-update">Cập nhật</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
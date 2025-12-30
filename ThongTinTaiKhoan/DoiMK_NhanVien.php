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
<<<<<<< HEAD
    <?php include "../headfoot/header.php"; ?>
=======
    <?php include "../headfoot/headerNV.php"; ?>
    <?php
    include '../headfoot/connect.php';
    
    // Xử lý đổi mật khẩu khi submit form
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_SESSION['username'];
        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $confirm_pass = $_POST['confirm_password'];

        // Kiểm tra mật khẩu cũ trong database
        $sql = "SELECT MatKhau FROM quanlytaikhoan WHERE TenDangNhap = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && $user['MatKhau'] === $old_pass) {
            // Mật khẩu cũ đúng -> Cập nhật mật khẩu mới
            $sqlUpdate = "UPDATE quanlytaikhoan SET MatKhau = ? WHERE TenDangNhap = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ss", $new_pass, $username);
            
            if ($stmtUpdate->execute()) {
                echo "<script>alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.'); window.location.href='../DangNhap/logout.php';</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu cũ không đúng!');</script>";
        }
    }
    ?>
>>>>>>> origin/Form_TinTucVaUuDai
    <br><br><br><br><br><br>
    <div class="password-container">
    <div class="password-card">
        <h2 class="form-title">Đổi mật khẩu</h2>
        
<<<<<<< HEAD
        <form action="process-change-password.php" method="POST">
=======
        <form method="POST">
>>>>>>> origin/Form_TinTucVaUuDai
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
<?php
session_start();
include '../headfoot/connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='../DangNhap/login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // Kiểm tra lại mật khẩu xác nhận (Server-side validation)
    if ($new_pass !== $confirm_pass) {
        echo "<script>alert('Mật khẩu xác nhận không khớp!'); window.history.back();</script>";
        exit;
    }

    // Lấy mật khẩu hiện tại từ DB
    $sql = "SELECT MatKhau FROM quanlytaikhoan WHERE TenDangNhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // So sánh mật khẩu cũ
        // Lưu ý: Code hiện tại đang dùng plain text (không mã hóa). Nếu sau này bạn dùng password_hash thì cần sửa lại đoạn này dùng password_verify.
        if ($user['MatKhau'] === $old_pass) {
            // Cập nhật mật khẩu mới
            $sqlUpdate = "UPDATE quanlytaikhoan SET MatKhau = ? WHERE TenDangNhap = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("ss", $new_pass, $username);
            
            if ($stmtUpdate->execute()) {
                // Đổi thành công -> Đăng xuất để đăng nhập lại cho an toàn
                echo "<script>alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.'); window.location.href='../DangNhap/logout.php';</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật: " . $conn->error . "'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu cũ không đúng!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Tài khoản không tồn tại!'); window.history.back();</script>";
    }
} else {
    header("Location: ../TrangChu/formTrangChu.php");
}
?>
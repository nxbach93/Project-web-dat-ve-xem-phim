<?php
session_start(); // Phải khởi tạo để PHP biết session nào cần xóa

// 1. Xóa các biến trong mảng $_SESSION
$_SESSION = array(); 

// 2. Xóa Cookie của Session trên trình duyệt (giúp bảo mật hơn)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Hủy bỏ hoàn toàn session trên server
session_destroy(); 

// 4. CHUYỂN HƯỚNG (Quan trọng: Sửa đường dẫn tại đây)
// Nếu file này nằm trong thư mục Login, bạn cần lùi lại để ra thư mục gốc
header("Location: ../TrangChu/formTrangChu.php"); 
exit(); // Luôn dùng exit để dừng mọi mã lệnh phía sau
?>
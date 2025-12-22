<?php
session_start();
include '../DangNhap/db.php';

// Kiểm tra quyền
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'employee')) {
    die("Bạn không có quyền thực hiện thao tác này.");
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Thực hiện xóa
    $sql = "DELETE FROM tintuc WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Xóa tin tức thành công!'); window.location.href='formTinTuc.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa: " . $stmt->error . "'); window.location.href='formTinTuc.php';</script>";
    }
} else {
    header("Location: formTinTuc.php");
}
?>
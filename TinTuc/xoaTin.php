<?php
session_start();
include '../DangNhap/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Thực hiện xóa
    $sql = "DELETE FROM tintuc WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Xóa tin tức thành công!'); window.location.href='formTinTucNV.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa: " . $stmt->error . "'); window.location.href='formTinTucNV.php';</script>";
    }
} else {
    header("Location: formTinTucNV.php");
}
?>
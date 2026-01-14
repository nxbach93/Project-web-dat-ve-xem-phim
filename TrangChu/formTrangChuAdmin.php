<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    unset($_SESSION['username']);
    header("Location: formTrangChuAdmin.php");
    exit();
}
include('../headfoot/connect.php');

// Xử lý Xóa nhân viên
if (isset($_GET['delete_user'])) {
    $userToDelete = $_GET['delete_user'];
    // Chỉ xóa tài khoản là nhân viên (IDQuyen = 2) để an toàn
    $sqlDelete = "DELETE FROM quanlytaikhoan WHERE TenDangNhap = ? AND IDQuyen = 2";
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("s", $userToDelete);
    if ($stmt->execute()) {
        echo "<script>alert('Xóa nhân viên thành công!'); window.location.href='formTrangChuAdmin.php';</script>";
    } else {
        echo "<script>alert('Lỗi xóa: " . $conn->error . "');</script>";
    }
}

// Lấy danh sách nhân viên (IDQuyen = 2)
$sql = "SELECT * FROM quanlytaikhoan WHERE IDQuyen = 2";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên - Admin</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="formTrangChuAdmin.css">
</head>
<body>

<?php include('../headfoot/headerAdmin.php'); ?>

<main class="admin-container">
    <div class="admin-header">
        <h2>Danh sách nhân viên</h2>
        <!-- Nút thêm mới (Logic thêm sẽ ở trang khác hoặc modal) -->
        <a href="../DangNhap/formDangKyNV.php" class="btn-add">+ Thêm nhân viên</a>
    </div>

    <div class="table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Ngày sinh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['TenDangNhap']) ?></td>
                            <td><?= htmlspecialchars($row['HoVaTen']) ?></td>
                            <td><?= htmlspecialchars($row['Email']) ?></td>
                            <td><?= htmlspecialchars($row['SDT']) ?></td>
                            <td><?= htmlspecialchars($row['NgaySinh']) ?></td>
                            <td class="action-cells">
                                <a href="formSuaNhanVien.php?user=<?= $row['TenDangNhap'] ?>" class="btn-edit">Chi tiết</a>
                                <a href="formTrangChuAdmin.php?delete_user=<?= $row['TenDangNhap'] ?>" 
                                   class="btn-delete"
                                   onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">Chưa có nhân viên nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
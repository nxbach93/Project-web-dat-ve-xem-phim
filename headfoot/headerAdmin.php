<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <!-- Logo -->
    <h1>
        <a href="../TrangChu/formTrangChuAdmin.php">Cinemas</a>
    </h1>

    <!-- Auth -->
    <div class="auth">
    <?php if (isset($_SESSION['username'])): ?>
        
        <div class="dropdown">
            <a href="#" class="dropbtn"><?= htmlspecialchars($_SESSION['username']) ?> ▼</a>
            <div class="dropdown-content">
                <a href="../ThongTinTaiKhoan/ThongTinTKAdmin.php">Thông tin tài khoản</a>
                <a href="../TrangChu/formTrangChuAdmin.php">Quản lý nhân viên</a>
                <a href="../TrangChu/formTrangChuAdmin.php?logout=true">Đăng xuất</a>
            </div>
        </div>

    <?php else: ?>
        <a href="../DangNhap/formDangNhapAdmin.php">Đăng nhập</a>
    <?php endif; ?>
</div>
</header>

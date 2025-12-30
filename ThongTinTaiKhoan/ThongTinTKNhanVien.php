<?php
session_start();
require_once '../headfoot/connect.php';

// 1. Kiểm tra đăng nhập (Dành cho nhân viên)
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập!'); window.location.href='../DangNhap/formDangNhapNV.php';</script>";
    exit();
}

$username = $_SESSION['username'];

// 2. XỬ LÝ CẬP NHẬT THÔNG TIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra dữ liệu đầu vào cơ bản
    if (!isset($_POST['fullname'])) {
        echo "<script>alert('Dữ liệu không hợp lệ!');</script>";
        exit;
    }

    $hoTen    = trim($_POST['fullname']);
    $sdt      = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $ngaySinh = $_POST['dob'];
    $gioiTinh = $_POST['gender'];
    $diaChi   = trim($_POST['address']);

    // Câu lệnh Update
    $sqlUpdate = "UPDATE quanlytaikhoan SET HoVaTen=?, SDT=?, Email=?, NgaySinh=?, GioiTinh=?, DiaChi=? WHERE TenDangNhap=?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("sssssss", $hoTen, $sdt, $email, $ngaySinh, $gioiTinh, $diaChi, $username);
    
    if ($stmtUpdate->execute()) {
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='ThongTinNV.php';</script>";
        exit;
    } else {
        echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
    }
}

// 3. LẤY THÔNG TIN NHÂN VIÊN
// Join với bảng qlquyen để lấy tên chức vụ (LoaiTK)
$sql = "SELECT tk.*, q.LoaiTK 
        FROM quanlytaikhoan tk 
        LEFT JOIN qlquyen q ON tk.IDQuyen = q.IDQuyen 
        WHERE tk.TenDangNhap = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Không tìm thấy thông tin tài khoản!");
}

// Lấy chữ cái đầu làm avatar
$firstLetter = isset($user['HoVaTen']) ? mb_substr($user['HoVaTen'], 0, 1, 'UTF-8') : '?';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="ThongTinTK.css">
    <title>Thông tin tài khoản nhân viên</title>
</head>
<body>

    <?php include "../headfoot/header.php"; ?>
    <?php include "../headfoot/headerNV.php"; ?>

    <br><br><br>
    <div class="account-container">
        <h2 class="section-title">Thông tin tài khoản nhân viên</h2>
        
        <div class="account-content">
            <div class="account-sidebar">
                <div class="avatar-wrapper">
                    <div class="avatar-placeholder" id="avatarText">
                        <?= strtoupper($firstLetter) ?>
                    </div>
                </div>
                <h3 id="displayName"><?= htmlspecialchars($user['HoVaTen'] ?? 'Nhân viên') ?></h3>
                
                <div class="staff-status-box">
                    <br>
                    <p class="position">
                        Chức vụ: <span><?= htmlspecialchars($user['LoaiTK'] ?? 'Nhân viên') ?></span>
                    </p>
                </div>
            </div>

            <div class="account-main">
                <form id="profileForm" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullname" class="editable" 
                                value="<?= htmlspecialchars($user['HoVaTen'] ?? '') ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="editable" 
                                value="<?= htmlspecialchars($user['SDT'] ?? '') ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="editable" 
                                value="<?= htmlspecialchars($user['Email'] ?? '') ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" name="dob" class="editable" 
                                value="<?= htmlspecialchars($user['NgaySinh'] ?? '') ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select name="gender" class="editable" disabled>
                                <option value="Nam" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                <option value="Nữ" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                <option value="Khác" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Khác') ? 'selected' : '' ?>>Khác</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" class="editable" 
                                value="<?= htmlspecialchars($user['DiaChi'] ?? '') ?>" disabled>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" id="editBtn" class="btn btn-outline">Cập nhật</button>
                        <button type="button" class="btn btn-outline" onclick="window.location.href='DoiMK_NhanVien.php'">Đổi mật khẩu</button>
                        <button type="submit" id="saveBtn" class="btn btn-primary" style="display: none;">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('editBtn').addEventListener('click', function() {
            // Lấy tất cả các ô input có class 'editable'
            const inputs = document.querySelectorAll('.editable');
            
            // Bỏ thuộc tính disabled để cho phép nhập liệu
            inputs.forEach(input => {
                input.removeAttribute('disabled');
                input.style.border = "1px solid #007bff"; // Highlight nhẹ
            });

            // Ẩn nút Cập nhật, hiện nút Lưu
            this.style.display = 'none';
            document.getElementById('saveBtn').style.display = 'inline-block';
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="ThongTinTK.css">
    <script src="ThongTinTK.js"></script>
    <title>Thông tin tài khoản nhân viên</title>
</head>
<body>
    <?php include "../headfoot/headerNV.php"; ?>
    <?php
    // Kết nối CSDL
    include '../headfoot/connect.php';

    $username = $_SESSION['username'];
    
    // Xử lý cập nhật thông tin khi người dùng nhấn Lưu
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['fullname'])) {
            echo "<script>alert('Dữ liệu không hợp lệ!');</script>";
            exit;
        }

        $hoTen = trim($_POST['fullname']);
        $sdt = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $ngaySinh = $_POST['dob'];
        $gioiTinh = $_POST['gender'];
        $diaChi = trim($_POST['address']);

        $sqlUpdate = "UPDATE quanlytaikhoan SET HoVaTen=?, SDT=?, Email=?, NgaySinh=?, GioiTinh=?, DiaChi=? WHERE TenDangNhap=?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sssssss", $hoTen, $sdt, $email, $ngaySinh, $gioiTinh, $diaChi, $username);
        
        if ($stmtUpdate->execute()) {
            echo "<script>alert('Cập nhật thông tin thành công!');</script>";
            // Refresh lại trang
            echo "<script>window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Lỗi cập nhật: " . $conn->error . "');</script>";
        }
    }

    // Lấy thông tin nhân viên từ database
    // Join với bảng quyền để lấy tên chức vụ (LoaiTK)
    $sql = "SELECT tk.*, q.LoaiTK FROM quanlytaikhoan tk LEFT JOIN qlquyen q ON tk.IDQuyen = q.IDQuyen WHERE tk.TenDangNhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('Không tìm thấy thông tin tài khoản!');</script>";
    }
    ?>
    <br><br><br>
    <div class="account-container">
        <h2 class="section-title">Thông tin tài khoản nhân viên</h2>
        
        <div class="account-content">
            <div class="account-sidebar">
                <div class="avatar-wrapper">
                    <div class="avatar-placeholder" id="avatarText"><?= isset($user['HoVaTen']) ? strtoupper(mb_substr($user['HoVaTen'], 0, 1, 'UTF-8')) : '?' ?></div>
                </div>
                <h3 id="displayName"><?= htmlspecialchars($user['HoVaTen'] ?? '') ?></h3>
                <div class="staff-status-box">
                    <br>
                    <br>
        <p class="position">Chức vụ: <span><?= htmlspecialchars($user['LoaiTK'] ?? 'Nhân viên') ?></span></p>
    </div>
            </div>

            <div class="account-main">
                <form id="profileForm" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullname" value="<?= htmlspecialchars($user['HoVaTen'] ?? '') ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="<?= htmlspecialchars($user['SDT'] ?? '') ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['Email'] ?? '') ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" name="dob" value="<?= htmlspecialchars($user['NgaySinh'] ?? '') ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select name="gender" disabled>
                                <option value="Nam" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                                <option value="Nữ" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                                <option value="Khác" <?= (isset($user['GioiTinh']) && $user['GioiTinh'] == 'Khác') ? 'selected' : '' ?>>Khác</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" value="<?= htmlspecialchars($user['DiaChi'] ?? '') ?>" readonly>
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
</body>
</html>
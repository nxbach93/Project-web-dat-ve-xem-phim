<?php
session_start();
require_once '../headfoot/connect.php';

// 1. Kiểm tra đăng nhập
// Giả sử bạn lưu ID tài khoản vào session là 'user_id' hoặc 'IDTK'
if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    header("Location: ../DangNhap/formDangNhapKH.php");
    exit();
}

// Ưu tiên dùng ID nếu có, nếu không thì query lấy ID từ username
$idtk = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Nếu chỉ có username, lấy IDTK ra (để chuẩn hóa việc update theo ID)
if (!$idtk && $username) {
    $stmt_GetID = $conn->prepare("SELECT IDTK FROM QuanLyTaiKhoan WHERE TenDangNhap = ?");
    $stmt_GetID->bind_param("s", $username);
    $stmt_GetID->execute();
    $resID = $stmt_GetID->get_result()->fetch_assoc();
    if ($resID) {
        $idtk = $resID['IDTK'];
    }
}

// 2. XỬ LÝ CẬP NHẬT KHI NHẤN NÚT LƯU
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile'])) {
    $fullname = trim($_POST['fullname']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $dob      = $_POST['dob'];
    $gender   = $_POST['gender'];
    $address  = trim($_POST['address']);

    // Validate cơ bản (nếu cần)
    
    // Câu lệnh Update
    $sql_update = "UPDATE QuanLyTaiKhoan SET HoVaTen=?, SDT=?, Email=?, NgaySinh=?, GioiTinh=?, DiaChi=? WHERE IDTK=?";
    $stmt_up = $conn->prepare($sql_update);
    // Lưu ý: GioiTinh viết đúng chính tả cột trong DB, kiểu dữ liệu ssssssi (6 string, 1 int)
    $stmt_up->bind_param("ssssssi", $fullname, $phone, $email, $dob, $gender, $address, $idtk);
    
    if ($stmt_up->execute()) {
        echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href='ThongTinTK.php';</script>";
        exit();
    } else {
        echo "<script>alert('Có lỗi xảy ra: " . $conn->error . "');</script>";
    }
}

// 3. TRUY VẤN LẤY DỮ LIỆU HIỂN THỊ
$sql = "SELECT * FROM QuanLyTaiKhoan WHERE IDTK = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idtk);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Không tìm thấy dữ liệu tài khoản.");
}

// Lấy chữ cái đầu của tên để làm Avatar
$firstLetter = isset($user['HoVaTen']) ? mb_substr($user['HoVaTen'], 0, 1, "UTF-8") : "?";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="ThongTinTK.css">
    <title>Thông tin tài khoản</title>
</head>
<body>
    <?php include "../headfoot/header.php"; ?>

    <br><br><br>
    <div class="account-container">
        <h2 class="section-title">Thông tin tài khoản</h2>
        
        <div class="account-content">
            <div class="account-sidebar">
                <div class="avatar-wrapper">
                    <div class="avatar-placeholder" id="avatarText">
                        <?= strtoupper($firstLetter); ?>
                    </div>
                </div>
                <h3 id="displayName"><?= htmlspecialchars($user['HoVaTen'] ?? 'Khách hàng') ?></h3>
                <div class="points-card">
                    <span class="label">Điểm thành viên</span>
                    <div class="points-value">
                        <?= number_format($user['DiemThanhVien'] ?? 0) ?>
                    </div>
                </div>
            </div>

            <div class="account-main">
                <form id="profileForm" action="" method="POST">
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
                        
                        <button type="button" class="btn btn-outline" id="changePassBtn" 
                                onclick="window.location.href='DoiMK_Khach.php'">Đổi mật khẩu</button>
                        
                        <button type="submit" name="save_profile" id="saveBtn" 
                                class="btn btn-primary" style="display: none;">Lưu thay đổi</button>
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
                // Chuyển style để người dùng biết là đang sửa được (tùy chọn)
                input.style.border = "1px solid #007bff";
            });

            // Ẩn nút Cập nhật và Đổi mật khẩu, hiện nút Lưu
            this.style.display = 'none';
            document.getElementById('changePassBtn').style.display = 'none';
            document.getElementById('saveBtn').style.display = 'inline-block';
        });
    </script>
</body>
</html>
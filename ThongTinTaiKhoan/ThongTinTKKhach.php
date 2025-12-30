<?php
    require_once '../headfoot/connect.php';
    session_start();

    // 1. Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    $idtk = $_SESSION['user_id'];

    // 2. XỬ LÝ CẬP NHẬT KHI NHẤN NÚT LƯU
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_profile'])) {
        $fullname = $_POST['fullname'];
        $phone    = $_POST['phone'];
        $email    = $_POST['email'];
        $dob      = $_POST['dob'];
        $gender   = $_POST['gender'];
        $address  = $_POST['address'];

        // Câu lệnh Update chuẩn theo bảng QuanLyTaiKhoan của bạn
        $sql_update = "UPDATE QuanLyTaiKhoan SET HoVaTen=?, SDT=?, Email=?, NgaySinh=?, GIoiTinh=?, DiaChi=? WHERE IDTK=?";
        $stmt_up = $conn->prepare($sql_update);
        $stmt_up->bind_param("ssssssi", $fullname, $phone, $email, $dob, $gender, $address, $idtk);
        
        if ($stmt_up->execute()) {
            // Thông báo và tải lại trang để cập nhật dữ liệu mới nhất
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
    $firstLetter = mb_substr($user['HoVaTen'], 0, 1, "UTF-8");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="ThongTinTK.css">
    <script src="ThongTinTK.js"></script>
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
                    <div class="avatar-placeholder" id="avatarText"><?php echo strtoupper($firstLetter); ?></div>
                </div>
                <h3 id="displayName"><?php echo $user['HoVaTen']; ?></h3>
                <div class="points-card">
                    <span class="label">Điểm thành viên</span>
                    <div class="points-value"><?php echo number_format($user['DiemThanhVien']); ?></div>
                </div>
            </div>

            <div class="account-main">
                <form id="profileForm" action="" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Họ và tên</label>
                            <input type="text" name="fullname" value="<?php echo $user['HoVaTen']; ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" value="<?php echo $user['SDT']; ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo $user['Email']; ?>" disabled required>
                        </div>
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" name="dob" value="<?php echo $user['NgaySinh']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select name="gender" disabled>
                                <option value="Nam" <?php echo ($user['GIoiTinh'] == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                                <option value="Nữ" <?php echo ($user['GIoiTinh'] == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                                <option value="Khác" <?php echo ($user['GIoiTinh'] == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                            </select>
                        </div>
                        <div class="form-group full-width">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" value="<?php echo $user['DiaChi']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" id="editBtn" class="btn btn-outline">Cập nhật</button>
                        <button type="submit" name="save_profile" id="saveBtn" class="btn btn-primary" style="display: none;">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
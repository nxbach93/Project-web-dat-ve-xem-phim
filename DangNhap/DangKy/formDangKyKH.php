<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký khách hàng</title>
</head>
<body>

<h2>Đăng ký tài khoản khách hàng</h2>

<form method="post" action="register_process.php">

    <label>Họ và tên</label><br>
    <input type="text" name="ho_ten" required><br><br>

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Số điện thoại</label><br>
    <input type="text" name="so_dien_thoai" required><br><br>

    <label>Ngày sinh</label><br>
    <input type="date" name="ngay_sinh" required><br><br>

    <label>Giới tính</label><br>
    <select name="gioi_tinh">
        <option>Nam</option>
        <option>Nữ</option>
        <option>Khác</option>
    </select><br><br>

    <label>Thành phố / Tỉnh</label><br>
    <select name="dia_chi" required>
        <option value="">-- Chọn tỉnh / thành phố --</option>
        <option>An Giang</option>
        <option>Bà Rịa - Vũng Tàu</option>
        <option>Bắc Giang</option>
        <option>Bắc Kạn</option>
        <option>Bạc Liêu</option>
        <option>Bắc Ninh</option>
        <option>Bến Tre</option>
        <option>Bình Định</option>
        <option>Bình Dương</option>
        <option>Bình Phước</option>
        <option>Bình Thuận</option>
        <option>Cà Mau</option>
        <option>Cần Thơ</option>
        <option>Cao Bằng</option>
        <option>Đà Nẵng</option>
        <option>Đắk Lắk</option>
        <option>Đắk Nông</option>
        <option>Điện Biên</option>
        <option>Đồng Nai</option>
        <option>Đồng Tháp</option>
        <option>Gia Lai</option>
        <option>Hà Giang</option>
        <option>Hà Nam</option>
        <option>Hà Nội</option>
        <option>Hà Tĩnh</option>
        <option>Hải Dương</option>
        <option>Hải Phòng</option>
        <option>Hậu Giang</option>
        <option>Hòa Bình</option>
        <option>Hưng Yên</option>
        <option>Khánh Hòa</option>
        <option>Kiên Giang</option>
        <option>Kon Tum</option>
        <option>Lai Châu</option>
        <option>Lâm Đồng</option>
        <option>Lạng Sơn</option>
        <option>Lào Cai</option>
        <option>Long An</option>
        <option>Nam Định</option>
        <option>Nghệ An</option>
        <option>Ninh Bình</option>
        <option>Ninh Thuận</option>
        <option>Phú Thọ</option>
        <option>Phú Yên</option>
        <option>Quảng Bình</option>
        <option>Quảng Nam</option>
        <option>Quảng Ngãi</option>
        <option>Quảng Ninh</option>
        <option>Quảng Trị</option>
        <option>Sóc Trăng</option>
        <option>Sơn La</option>
        <option>Tây Ninh</option>
        <option>Thái Bình</option>
        <option>Thái Nguyên</option>
        <option>Thanh Hóa</option>
        <option>Thừa Thiên Huế</option>
        <option>Tiền Giang</option>
        <option>TP Hồ Chí Minh</option>
        <option>Trà Vinh</option>
        <option>Tuyên Quang</option>
        <option>Vĩnh Long</option>
        <option>Vĩnh Phúc</option>
        <option>Yên Bái</option>
    </select>
    <br><br>

    <label>Tên đăng nhập</label><br>
    <input type="text" name="username" required><br><br>

    <label>Mật khẩu</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Đăng ký</button>
</form>

</body>
</html>

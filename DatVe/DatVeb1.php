<?php
session_start();
require_once "../headfoot/connect.php";

// 1. Kiểm tra ID lịch chiếu từ URL
$idlc = isset($_GET['idlc']) ? intval($_GET['idlc']) : 0;

if ($idlc <= 0) {
    die("Lỗi: Không nhận được ID lịch chiếu hợp lệ từ trình duyệt. (ID hiện tại: $idlc)");
}

// 2. TRUY VẤN KIỂM TRA TỪNG BƯỚC (Để tìm lỗi nằm ở bảng nào)
// Bước A: Kiểm tra xem IDLichChieu có tồn tại không
$check_lc = $conn->query("SELECT * FROM qllichchieu WHERE IDLichChieu = $idlc");
$lc_data = $check_lc->fetch_assoc();

if (!$lc_data) {
    die("Lỗi: IDLichChieu = $idlc không tồn tại trong bảng 'qllichchieu'. Hãy kiểm tra lại database.");
}

// Bước B: Nếu có Lịch chiếu, lấy thông tin đầy đủ bằng JOIN
$sql = "SELECT lc.*, p.*, r.TenRap, r.DiaChi 
        FROM qllichchieu lc
        INNER JOIN qlphim p ON lc.IDPhim = p.IDPhim
        INNER JOIN rap r ON lc.IDRap = r.IDRap
        WHERE lc.IDLichChieu = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idlc);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

// Bước C: Nếu Bước A có mà Bước B rỗng => Sai lệch khóa ngoại
if (!$data) {
    echo "<h3>Lỗi ràng buộc dữ liệu:</h3>";
    echo "- IDPhim trong lịch chiếu là: " . $lc_data['IDPhim'] . " (Kiểm tra xem mã này có trong bảng 'qlphim' không?) <br>";
    echo "- IDRap trong lịch chiếu là: " . $lc_data['IDRap'] . " (Kiểm tra xem mã này có trong bảng 'rap' không?) <br>";
    die("Dữ liệu JOIN bị rỗng do thiếu thông tin ở bảng Phim hoặc Rạp.");
}

// 3. LẤY GIÁ VÉ (Giả sử lấy từ bảng thongtinve)
$gia_ve = 0;
$gia_query = $conn->query("SELECT GiaNgayThuong FROM thongtinve LIMIT 1");
if ($gia_query && $row_gia = $gia_query->fetch_assoc()) {
    $gia_ve = $row_gia['GiaNgayThuong'];
}

$hang_ghe = ['A', 'B', 'C', 'D', 'E'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DatVe.css">
    <link rel="stylesheet" href="
<?php
session_start();
require_once "../headfoot/connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['idlc'])) {
    header("Location: ../trangchu/index.php");
    exit();
}

$idlc = intval($_POST['idlc']);
$ds_ghe_id = $_POST['ds_ghe_id']; 
$ds_ghe_ten = $_POST['ds_ghe_ten'];
$tong_tien_ghe = intval($_POST['tong_tien']); 

$sql_info = "SELECT lc.*, p.TenPhim, p.Poster, r.TenRap 
             FROM qllichchieu lc
             JOIN qlphim p ON lc.IDPhim = p.IDPhim
             JOIN rap r ON lc.IDRap = r.IDRap
             WHERE lc.IDLichChieu = ?";
$stmt = $conn->prepare($sql_info);
$stmt->bind_param("i", $idlc);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();


$u_name = ""; $u_phone = ""; $u_email = "";
if(isset($_SESSION['username'])) {
    $user_q = $conn->query("SELECT * FROM quanlytaikhoan WHERE TenDangNhap='".$_SESSION['username']."'");
    if($user_q && $u = $user_q->fetch_assoc()){
        $u_name = $u['HoVaTen'];
        $u_phone = $u['SDT'];
        $u_email = $u['Email'];
    }
}


$combos = [];

$cb_query = $conn->query("SELECT * FROM dichvu WHERE LoaiDV = 'DoAn'"); 
if($cb_query){
    while($row = $cb_query->fetch_assoc()) $combos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh Toán - <?= htmlspecialchars($data['TenPhim']) ?></title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DatVeB2.css"> 
</head>
<body>
    <?php include "../headfoot/header.php"; ?>
    <br><br><br>

    <form action="XuLyThanhToan.php" method="POST" id="checkoutForm">
        
        <input type="hidden" name="idlc" value="<?= $idlc ?>">
        <input type="hidden" name="ds_ghe_id" value="<?= $ds_ghe_id ?>">
        <input type="hidden" name="ds_ghe_ten" value="<?= $ds_ghe_ten ?>">
        <input type="hidden" name="tong_tien_ghe" id="input_tien_ghe" value="<?= $tong_tien_ghe ?>">
        <input type="hidden" name="tong_tien_combo" id="input_tien_combo" value="0">
        <input type="hidden" name="tong_thanh_toan" id="input_tong_cong" value="<?= $tong_tien_ghe ?>">

        <div class="checkout-wrapper">
            <div class="checkout-left">
                
                <div class="section-header">
                    <h2 class="section-title">THÔNG TIN KHÁCH HÀNG</h2>
                </div>
                <div class="customer-info-grid">
                    <div class="info-block">
                        <label>Họ Tên:</label>
                        <?php if($u_name): ?>
                            <p><?= htmlspecialchars($u_name) ?></p>
                            <input type="hidden" name="ho_ten" value="<?= htmlspecialchars($u_name) ?>">
                        <?php else: ?>
                            <input type="text" name="ho_ten" required placeholder="Nhập họ tên" class="input-field">
                        <?php endif; ?>
                    </div>
                    <div class="info-block">
                        <label>Số điện thoại:</label>
                        <?php if($u_phone): ?>
                            <p><?= htmlspecialchars($u_phone) ?></p>
                            <input type="hidden" name="sdt" value="<?= htmlspecialchars($u_phone) ?>">
                        <?php else: ?>
                            <input type="text" name="sdt" required placeholder="Nhập SĐT" class="input-field">
                        <?php endif; ?>
                    </div>
                    <div class="info-block">
                        <label>Email:</label>
                        <?php if($u_email): ?>
                            <p><?= htmlspecialchars($u_email) ?></p>
                            <input type="hidden" name="email" value="<?= htmlspecialchars($u_email) ?>">
                        <?php else: ?>
                            <input type="email" name="email" required placeholder="Nhập Email" class="input-field">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="ticket-detail">
                    <div class="detail-row header">
                        <span>LOẠI VÉ</span>
                        <span>SỐ LƯỢNG</span>
                        <span>TỔNG TIỀN</span>
                    </div>
                    <div class="detail-row">
                        <span>Ghế: <?= htmlspecialchars($ds_ghe_ten) ?></span>
                        <span><?= count(explode(',', $ds_ghe_id)) ?> vé</span>
                        <span style="color:#b71c1c; font-weight:bold"><?= number_format($tong_tien_ghe) ?> đ</span>
                    </div>
                </div>

                <div class="section-header">
                    <h2 class="section-title">ĐỒ ĂN/ ĐỒ UỐNG</h2>
                </div>
                <table class="combo-table">
                    <thead>
                        <tr>
                            <th>Combo</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($combos as $cb): ?>
                        <tr>
                            <td class="combo-name-cell">
                                <img src="../images/combo/<?= $cb['HinhAnh'] ?>" class="combo-thumb" onerror="this.src='https://via.placeholder.com/80'">
                                <div class="combo-info">
                                    <span class="combo-title"><?= htmlspecialchars($cb['TenDichVu']) ?></span>
                                    <span class="combo-desc"><?= htmlspecialchars($cb['MoTa']) ?></span>
                                </div>
                            </td>
                            <td style="font-weight:bold"><?= number_format($cb['Gia']) ?> đ</td>
                            <td>
                                <div class="quantity-control">
                                    <button class="qty-btn" type="button" onclick="updateQty(this, -1, <?= $cb['Gia'] ?>)">-</button>
                                    <input type="text" name="combo[<?= $cb['IDDichVu'] ?>]" value="0" readonly class="qty-input">
                                    <button class="qty-btn" type="button" onclick="updateQty(this, 1, <?= $cb['Gia'] ?>)">+</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="section-header payment-margin">
                    <h2 class="section-title">PHƯƠNG THỨC THANH TOÁN</h2>
                </div>
                <div class="payment-grid">
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="atm" checked>
                        <span class="checkmark"></span>
                        <img src="../images/icon-atm.png" onerror="this.style.display='none'">
                        <span>Thẻ nội địa</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="momo">
                        <span class="checkmark"></span>
                        <img src="../images/icon-momo.png" onerror="this.style.display='none'">
                        <span>Ví MoMo</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="qr">
                        <span class="checkmark"></span>
                        <img src="../images/icon-qr.png" onerror="this.style.display='none'">
                        <span>Mã QR</span>
                    </label>
                </div>

                <div class="payment-warning">
                    <p>* Vé đã mua không thể hoàn trả. Vui lòng kiểm tra kỹ thông tin.</p>
                </div>
            </div>

            <div class="checkout-right">
                <div class="movie-summary">
                    <img src="../images/movie/<?= $data['Poster'] ?>" class="side-poster">
                    <h3 style="color:#b71c1c; text-transform: uppercase;"><?= htmlspecialchars($data['TenPhim']) ?></h3>
                </div>
                <div class="side-info">
                    <p><strong>Rạp:</strong> <span><?= htmlspecialchars($data['TenRap']) ?></span></p>
                    <p><strong>Suất:</strong> <span><?= date('H:i', strtotime($data['GioChieu'])) ?> | <?= date('d/m/Y', strtotime($data['NgayChieu'])) ?></span></p>
                    <p><strong>Ghế:</strong> <span style="color:#e50914"><?= htmlspecialchars($ds_ghe_ten) ?></span></p>
                    <p><strong>Tiền vé:</strong> <span><?= number_format($tong_tien_ghe) ?> đ</span></p>
                    <p><strong>Combo:</strong> <span id="view_combo">0 đ</span></p>
                </div>
                
                <div class="timer-section">
                    Thời gian giữ vé: <span id="countdown">10:00</span>
                </div>

                <div class="final-total">
                    <span>Tổng cộng:</span>
                    <span class="price" id="view_total"><?= number_format($tong_tien_ghe) ?> đ</span>
                </div>
                <div class="action-btns">
                    <button class="btn-submit btn-back" type="button" onclick="history.back()">QUAY LẠI</button>
                    <button class="btn-submit btn-pay" type="submit">THANH TOÁN</button>
                </div>
            </div>
        </div>
    </form>

    <script>const BASE_PRICE = <?= $tong_tien_ghe ?>;</script>
    <script src="DatVeB2.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DatVe.css">
    <title>Đặt vé - Thanh toán</title>
</head>
<body>
    <?php include "../headfoot/header.php"; ?>
    <br><br>
    <div class="booking-container checkout-page">

    <div class="checkout-wrapper">
        <div class="checkout-left">
            <div class="section-header">
                <h2 class="section-title">THÔNG TIN THANH TOÁN</h2>
            </div>
            <div class="customer-info-grid">
                <div class="info-block">
                    <label>Họ Tên:</label>
                    <p>Nguyễn Xuân Bách</p>
                </div>
                <div class="info-block">
                    <label>Số điện thoại:</label>
                    <p>0987xxxxxx</p>
                </div>
                <div class="info-block">
                    <label>Email:</label>
                    <p>bachvijt@gmail.com</p>
                </div>
            </div>

            <div class="ticket-detail">
                <div class="detail-row header">
                    <span>LOẠI VÉ</span>
                    <span>SỐ LƯỢNG</span>
                    <span>GIÁ VÉ</span>
                    <span>TỔNG</span>
                </div>
                <div class="detail-row">
                    <span>GHẾ VIP</span>
                    <span>1 x 40.000</span>
                    <span>40.000 vnđ</span>
                    <span>40.000 vnđ</span>
                </div>
            </div>

            <div class="section-header">
                <h2 class="section-title">ĐỒ ĂN/ ĐỒ UỐNG</h2>
            </div>
            <table class="combo-table">
                <thead>
                    <tr>
                        <th>Tên Combo</th>
                        <th>Mô tả</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="combo-name-cell">
                            <img src="combo1.jpg" alt="combo" class="combo-thumb">
                            <span>Combo See Mê - Xương Rồng</span>
                        </td>
                        <td class="combo-desc">Tiết kiệm 56k!!! Sở hữu ngay 1 Ly Xương Rồng kèm nước + 1 bắp (69oz)</td>
                        <td>
                            <div class="quantity-control">
                                <button class="qty-btn" type="button">-</button>
                                <input type="text" value="0" readonly>
                                <button class="qty-btn" type="button">+</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="section-header payment-margin">
                <h2 class="section-title">PHƯƠNG THỨC THANH TOÁN</h2>
            </div>
            <div class="payment-methods">
                <p class="payment-note">Chọn thẻ thanh toán</p>
                <div class="payment-grid">
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="atm" checked>
                        <span class="checkmark"></span>
                        <img src="icon-atm.png" alt="ATM">
                        <span>Thẻ nội địa</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="visa">
                        <span class="checkmark"></span>
                        <img src="icon-visa.png" alt="Visa">
                        <span>Thẻ quốc tế</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="momo">
                        <span class="checkmark"></span>
                        <img src="icon-momo.png" alt="MoMo">
                        <span>Ví MoMo</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="zalopay">
                        <span class="checkmark"></span>
                        <img src="icon-zalopay.png" alt="ZaloPay">
                        <span>Ví ZaloPay</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="shopeepay">
                        <span class="checkmark"></span>
                        <img src="icon-shopeepay.png" alt="ShopeePay">
                        <span>Ví ShopeePay</span>
                    </label>
                    <label class="payment-item">
                        <input type="radio" name="payment_method" value="qr">
                        <span class="checkmark"></span>
                        <img src="icon-qr.png" alt="QR">
                        <span>Mã QR</span>
                    </label>
                </div>
            </div>

            <div class="payment-warning">
                <p>* Bạn vui lòng kiểm tra thông tin đầy đủ trước khi qua bước tiếp theo.</p>
                <p>* Vé đã hoàn thành thanh toán sẽ không được hoàn trả dưới mọi hình thức.</p>
            </div>
        </div>

        <div class="checkout-right">
            <div class="movie-summary">
                <img src="poster.jpg" class="side-poster">
                <h3>Avatar: Lửa Và Tro Tàn</h3>
                <p class="tag-2d">2D Phụ đề</p>
            </div>
            <div class="side-info">
                <p><strong>Rạp:</strong> Cinemas Thái Nguyên</p>
                <p><strong>Suất:</strong> 22:30 | 23/12/2025</p>
                <p><strong>Ghế:</strong> F4</p>
            </div>
            
            <div class="timer-display">
                <span>Thời gian còn lại:</span>
                <span id="countdown">05:00</span>
            </div>

            <div class="final-total">
                <span>Tổng cộng:</span>
                <span class="price">40.000 vnđ</span>
            </div>
            <div class="action-btns">
                <button class="btn-submit" type="submit">QUAY LẠI</button>
                <button class="btn-submit" type="submit">TIẾP TỤC</button>
            </div>
        </div>
    </div>

    <script src="DatVe.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="DatVe.css">
    <script src="DatVe.js"></script>
    <title>Đặt vé</title>
</head>
<body>
    <?php include "../headfoot/header.php"; ?>
    <br><br><br><br>
    <div class="booking-container">
    <div class="seat-selection">
        <div class="legend">
            <div class="item"><span class="seat"></span> Ghế trống</div>
            <div class="item"><span class="seat selected"></span> Ghế đang chọn</div>
            <div class="item"><span class="seat holding"></span> Ghế đang giữ</div>
            <div class="item"><span class="seat occupied"></span> Ghế đã bán</div>
        </div>

        <div class="screen">MÀN HÌNH</div>
        
        <div class="seat-map">
            <div class="row-A">
                <div class="seat">A1</div>
                <div class="seat occupied">A2</div>
                <div class="seat selected">A3</div>
                <div class="seat">A4</div>
                <div class="seat">A5</div>
                <div class="seat occupied">A6</div>
                <div class="seat selected">A7</div>
                <div class="seat">A8</div>
            </div>
            <div class="row-B">
                <div class="seat">B1</div>
                <div class="seat occupied">B2</div>
                <div class="seat selected">B3</div>
                <div class="seat">B4</div>
                <div class="seat">B5</div>
                <div class="seat occupied">B6</div>
                <div class="seat selected">B7</div>
                <div class="seat">B8</div>
            </div>
            <div class="row-C">
                <div class="seat">C1</div>
                <div class="seat occupied">C2</div>
                <div class="seat selected">C3</div>
                <div class="seat holding">C4</div>
                <div class="seat">C5</div>
                <div class="seat occupied">C6</div>
                <div class="seat selected">C7</div>
                <div class="seat">C8</div>
            </div>
            <div class="row-D">
                <div class="seat">D1</div>
                <div class="seat occupied">D2</div>
                <div class="seat selected">D3</div>
                <div class="seat holding">D4</div>
                <div class="seat">D5</div>
                <div class="seat occupied">D6</div>
                <div class="seat selected">D7</div>
                <div class="seat">D8</div>
            </div>
            <div class="row-E">
                <div class="seat">E1</div>
                <div class="seat occupied">E2</div>
                <div class="seat selected">E3</div>
                <div class="seat holding">E4</div>
                <div class="seat">E5</div>
                <div class="seat occupied">E6</div>
                <div class="seat selected">E7</div>
                <div class="seat">E8</div>
            </div>
        </div>

    </div>

    <div class="booking-summary">
        <h2 class="movie-title">AVATAR: DÒNG CHẢY CỦA NƯỚC</h2>
        <div class="info-item"><span>Rạp:</span> Cinemas Thái Nguyên</div>
        <div class="info-item"><span>Suất chiếu:</span> 19:00 | 23/12/2025</div>
        <div class="info-item"><span>Ghế chọn:</span> <b id="selected-seats-list">G5</b></div>
        
        <hr>
        
        <div class="total-section">
            <p>Tổng tiền:</p>
            <h3 id="total-price">120,000 VND</h3>
        </div>

        <div class="timer-section">
            Thời gian còn lại: <span id="countdown">10:00</span>
        </div>

        <button class="btn-continue">TIẾP TỤC</button>
    </div>
</div>
</body>
</html>
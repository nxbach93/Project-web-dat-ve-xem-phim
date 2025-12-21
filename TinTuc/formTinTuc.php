<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin Tức Điện Ảnh</title>
    <link rel="stylesheet" href="headfoot/header.css">
    <link rel="stylesheet" href="formTinTuc.css">
</head>
<body>

<?php include "headfoot/header.php"; ?>

<main class="news-container">
    <h2>Tin Tức & Sự Kiện</h2>
    
    <div class="news-list">
        <!-- Tin 1 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news1.jpg" alt="Avatar 2" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Bom tấn "Avatar: Dòng Chảy Của Nước" mở bán vé sớm</h3>
                <p>Siêu phẩm được mong chờ nhất thập kỷ của James Cameron đã sẵn sàng. Đặt vé ngay để chọn vị trí đẹp nhất!</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>

        <!-- Tin 2 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news2.jpg" alt="Thứ 3 Vui Vẻ" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Ưu đãi Thứ 3 Vui Vẻ - Vé chỉ từ 45k</h3>
                <p>Đừng bỏ lỡ cơ hội xem phim thả ga không lo về giá vào mỗi thứ 3 hàng tuần tại tất cả các cụm rạp.</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>
        
        <!-- Tin 3 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news3.jpg" alt="Combo Bắp Nước" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Tính năng mới: Đặt trước Combo Bắp Nước online</h3>
                <p>Tiết kiệm thời gian xếp hàng và nhận ưu đãi giảm giá tới 20% khi đặt kèm bắp nước qua website.</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>

        <!-- Tin 4 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news4.jpg" alt="Review Oppenheimer" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Review: "Oppenheimer" - Kiệt tác điện ảnh</h3>
                <p>Một trải nghiệm điện ảnh choáng ngợp từ Christopher Nolan. Cùng phân tích những điểm nhấn ấn tượng nhất.</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>

        <!-- Tin 5 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news5.jpg" alt="Thành viên" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Đăng ký thành viên - Tích điểm đổi quà hấp dẫn</h3>
                <p>Trở thành thành viên thân thiết để tích lũy điểm thưởng và đổi lấy vé xem phim, voucher và quà tặng độc quyền.</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>

        <!-- Tin 6 -->
        <div class="news-item">
            <div class="news-img">
                <img src="images/news6.jpg" alt="Phim Kinh Dị" onerror="this.src='https://via.placeholder.com/400x250?text=News+Image'">
            </div>
            <div class="news-info">
                <h3>Top 5 phim kinh dị đáng xem nhất tháng này</h3>
                <p>Thử thách lòng can đảm với danh sách những bộ phim kinh dị rùng rợn đang làm mưa làm gió tại phòng vé.</p>
                <a href="#" class="btn-detail">Xem chi tiết</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>


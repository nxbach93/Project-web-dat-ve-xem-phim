<?php
session_start();
include '../DangNhap/db.php';

// Lấy danh sách tin tức từ database (Sắp xếp theo ID giảm dần để tin mới nhất lên đầu)
$news_list = [];
$sql = "SELECT * FROM tintuc ORDER BY id DESC";
try {
    $result = mysqli_query($conn, $sql);
} catch (Exception $e) {
    die("Lỗi: Bảng 'tintuc' chưa tồn tại trong CSDL hoặc lỗi truy vấn. <br>Chi tiết: " . $e->getMessage());
}
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $news_list[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin Tức Điện Ảnh</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="formTinTucKH.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include "../headfoot/header.php"; ?>

<main class="news-container">
    <h2>Tin Tức & Sự Kiện</h2>
    
    <div class="news-list">
        <?php if (empty($news_list)): ?>
            <p style="text-align: center; width: 100%;">Chưa có tin tức nào.</p>
        <?php else: ?>
            <?php foreach ($news_list as $item): ?>
            <div class="news-item">
                <div class="news-img">
                    <img src="<?= htmlspecialchars($item['hinh_anh']) ?>" alt="<?= htmlspecialchars($item['tieu_de']) ?>" onerror="this.src='../image/<?=$item['hinh_anh'] ?>';">
                </div>
                <div class="news-info">
                    <h3><?= htmlspecialchars($item['tieu_de']) ?></h3>
                    <p><?= htmlspecialchars($item['mo_ta']) ?></p>
                    
                    <div class="action-group">
                        <a href="chiTietTin.php?id=<?= $item['id'] ?>" class="btn-detail">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

</body>
</html>

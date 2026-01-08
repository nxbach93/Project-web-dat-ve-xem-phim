<?php
session_start();
include '../headfoot/connect.php';

// Validate ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID tin tức không hợp lệ.');
}
$id = (int)$_GET['id'];

// Fetch news item from DB using prepared statements to prevent SQL Injection
$stmt = $conn->prepare("SELECT * FROM tintuc WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Không tìm thấy tin tức.');
}

$tin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết - <?= htmlspecialchars($tin['tieu_de']) ?></title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="chiTietTin.css"> <!-- A single CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include "../headfoot/header.php"; ?>

<main class="detail-container">
    <div class="detail-card">
        <div class="detail-img">
            <img src="<?= htmlspecialchars($tin['hinh_anh']) ?>" alt="<?= htmlspecialchars($tin['tieu_de']) ?>" onerror="this.src='https://via.placeholder.com/900x600?text=Image+Not+Found'">
        </div>
        <div class="detail-content">
            <h1><?= htmlspecialchars($tin['tieu_de']) ?></h1>
            <p class="meta-info"><i class="fa-solid fa-newspaper"></i> Tin tức & Sự kiện</p>
            <div class="content-body"><?= nl2br(htmlspecialchars($tin['noi_dung'])) ?></div>
            
            <div class="action-buttons">
                <a href="formTinTuc.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Quay lại</a>
            </div>
        </div>
    </div>
</main>

</body>
</html>
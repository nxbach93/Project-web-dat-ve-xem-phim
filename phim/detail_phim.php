<?php
require "../headfoot/connect.php";

/* ===== CHECK ID ===== */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: phim.php");
    exit();
}

$id = (int)$_GET['id'];

/* ===== GET MOVIE ===== */
$sql = "SELECT * FROM qlphim WHERE IDPhim = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

if (!$movie) {
    echo "❌ Không tìm thấy phim";
    exit();
}

/* ===== FILTER COMMENT ===== */
$filter = $_GET['filter'] ?? 'newest';
$order = ($filter === 'oldest') ? 'ASC' : 'DESC';

/* ===== GET COMMENT ===== */
$sqlComment = "
    SELECT * FROM comment 
    WHERE IDPhim = ?
    ORDER BY CreatedTime $order
";
$stmtCmt = $conn->prepare($sqlComment);
$stmtCmt->bind_param("i", $id);
$stmtCmt->execute();
$comments = $stmtCmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($movie['TenPhim']) ?></title>
    <link rel="stylesheet" href="../headfoot/header.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="detail_phim.css">
    
</head>

<body>

<?php include "../headfoot/header.php"; ?>

<div class="movie-detail">

    <!-- POSTER -->
    <div class="movie-poster">
        <img 
            src="../images/movie/<?= htmlspecialchars($movie['Poster']) ?>" 
            alt="<?= htmlspecialchars($movie['TenPhim']) ?>"
        >
        
        <p>
            <button class="muave">
                Mua vé
            </button>
        </p>
    </div>

    <!-- INFO -->
    <div class="movie-info">
        <h2><?= htmlspecialchars($movie['TenPhim']) ?></h2>

        <p><strong>🎭 Thể loại:</strong> <?= htmlspecialchars($movie['TheLoai']) ?></p>
        <p><strong>🌍 Quốc gia:</strong> <?= htmlspecialchars($movie['QuocGia']) ?></p>
        <p><strong>📅 Ngày khởi chiếu:</strong> <?= $movie['NgayKhoiChieu'] ?></p>
        <p><strong>⏱ Thời lượng:</strong> <?= $movie['ThoiLuong'] ?> phút</p>
        <p><strong>🎬 Đạo diễn:</strong> <?= htmlspecialchars($movie['DaoDien']) ?></p>
        <p><strong>🎤 Diễn viên:</strong> <?= htmlspecialchars($movie['DienVien']) ?></p>
        <p><strong>⭐ Rate:</strong> <?= $movie['Rate'] ?? 'Chưa có' ?>/10</p>

        <hr>

        <h4>📖 Tóm tắt</h4>
        <p><?= nl2br(htmlspecialchars($movie['TomTat'])) ?></p>

        <hr>

        <!-- COMMENT SECTION -->
        <h4>💬 Bình luận</h4>

        <!-- FILTER -->
        <form method="get" class="comment-filter">
            <input type="hidden" name="id" value="<?= $id ?>">
            <select name="filter" onchange="this.form.submit()">
                <option value="newest" <?= $filter === 'newest' ? 'selected' : '' ?>>
                    Mới nhất
                </option>
                <option value="oldest" <?= $filter === 'oldest' ? 'selected' : '' ?>>
                    Cũ nhất
                </option>
            </select>
        </form>

        <!-- ADD COMMENT -->
        <form action="addcomment.php" method="post" class="comment-form">
            <input type="hidden" name="movie_id" value="<?= $id ?>">

            <div class="comment-input">
                <img src="../images/avatar/avatar1.png" class="avatar">

                <textarea  class="content"
                    name="content" 
                    placeholder="Nhập bình luận của bạn..." 
                    required
                ></textarea>

                <button type="submit">Gửi</button>
            </div>
        </form>

        <!-- COMMENT LIST -->
        <div class="comment-list">
            <?php if ($comments->num_rows > 0): ?>
                <?php while ($c = $comments->fetch_assoc()): ?>
                    <div class="comment-item">
                        <img 
                            src="../images/avatar/<?= htmlspecialchars($c['Avatar']) ?>" 
                            class="avatar"
                        >

                        <div class="comment-content">
                            <p><?= nl2br(htmlspecialchars($c['Content'])) ?></p>
                            <small><?= $c['CreatedTime'] ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Chưa có bình luận nào.</p>
            <?php endif; ?>
        </div>


    </div>
</div>
<button id="scrollToTopButton" onclick="window.scrollTo({top:0,behavior:'smooth'})">
     <i class="fas fa-arrow-up"></i> </button>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">       
     </script>
</body>
</html>

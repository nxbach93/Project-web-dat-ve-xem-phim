<?php
require_once '../headfoot/connect.php';
session_start();

// Kiểm tra phân quyền
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Xử lý xóa phim
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM movie WHERE movie_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: phimAdmin.php");
    exit();
}

// Lấy danh sách phim
$sql = "SELECT * FROM movie";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phim</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="phimAdmin.css">
    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include "../headfoot/header.php"; ?>

<main class="container movie-list">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Danh sách phim</h2>
        <a href="add_phim.php" class="btn btn-success"><i class="fas fa-plus"></i> Thêm phim</a>
    </div>

    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6 col">
                <div class="movie-card">
                    <a href="detail_phim.php?id=<?= $row['movie_id'] ?>">
                        <img class="poster" src="../images/movie/<?= htmlspecialchars($row['poster']) ?>" alt="<?= htmlspecialchars($row['title_movie']) ?>">
                    </a>

                    <h5><?= htmlspecialchars($row['title_movie']) ?></h5>
                    <p><?= htmlspecialchars($row['genre']) ?> • <?= $row['duration'] ?> phút</p>

                    <div class="d-flex gap-2">
                        <a href="edit_phim.php?id=<?= $row['movie_id'] ?>" class="btn btn-primary w-50">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="phimAdmin.php?delete=<?= $row['movie_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa phim này?');" class="btn btn-danger w-50">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- SCROLL TO TOP -->
<button id="scrollToTopButton" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

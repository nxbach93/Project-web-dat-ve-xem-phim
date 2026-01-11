<?php
require_once '../headfoot/connect.php';
session_start();

// /* ================= CHECK LOGIN ================= */
// if (!isset($_SESSION['LoaiTK'])) {
//     header("Location: ../login.php");
//     exit();
// }

// /* ================= CHECK QUYỀN ================= */
// /*
//   admin  → full quyền
//   staff  → thêm, sửa (KHÔNG xóa)
//   user   → cấm
// */
// if (!in_array($_SESSION['LoaiTK'], ['admin', 'staff'])) {
//     echo "❌ Bạn không có quyền truy cập trang này";
//     exit();
// }

// $isAdmin = ($_SESSION['LoaiTK'] === 'admin');

// /* ================= XÓA PHIM (CHỈ ADMIN) ================= */
// if ($isAdmin && isset($_GET['delete']) && is_numeric($_GET['delete'])) {
//     $id = (int) $_GET['delete'];

//     $stmt = $conn->prepare("DELETE FROM qlphim WHERE IDPhim = ?");
//     $stmt->bind_param("i", $id);
//     $stmt->execute();

//     header("Location: phimAdmin.php");
//     exit();
// }

/* ================= LẤY DANH SÁCH PHIM ================= */
$sql = "SELECT * FROM qlphim ORDER BY IDPhim DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phim</title>

    

    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="phimAdmin.css">
</head>

<body>

<?php include "../headfoot/headerNV.php"; ?>

<main class="container movie-list">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>🎬 Quản lý phim</h2>

        <a href="add_phim.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm phim
        </a>
    </div>

    <!-- MOVIE GRID -->
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="movie-card h-100">

                    <!-- POSTER -->
                    <a href="detail_phim.php?id=<?= $row['IDPhim'] ?>">
                        <img
                            class="poster"
                            src="../../images/movie/<?= htmlspecialchars($row['Poster']) ?>"
                            alt="<?= htmlspecialchars($row['TenPhim']) ?>"
                        >
                    </a>

                    <!-- TITLE -->
                    <h5 class="mt-2">
                        <?= htmlspecialchars($row['TenPhim']) ?>
                    </h5>

                    <!-- INFO -->
                    <p class="movie-meta mb-2">
                        <?= htmlspecialchars($row['TheLoai']) ?>
                        • <?= $row['ThoiLuong'] ?> phút
                    </p>

                    <p class="small mb-3">
                        🌍 <?= htmlspecialchars($row['QuocGia']) ?><br>
                        ⭐ <?= $row['Rate'] ?? 'Chưa có' ?>/10
                    </p>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex gap-2">
                        <!-- SỬA (ADMIN + STAFF) -->
                        <a href="edit_phim.php?id=<?= $row['IDPhim'] ?>"
                           class="btn btn-primary w-100">
                            <i class="fas fa-edit"></i> Sửa
                        </a>

                        <!-- XÓA (CHỈ ADMIN) -->
                        <?php  ?>
                            <a href="phimAdmin.php?delete=<?= $row['IDPhim'] ?>"
                               onclick="return confirm('Bạn có chắc muốn xóa phim này?');"
                               class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Xóa
                            </a>
                        <?php  ?>
                    </div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- SCROLL TO TOP -->
<button id="scrollToTopButton"
        onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

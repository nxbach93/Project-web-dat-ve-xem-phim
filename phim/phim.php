<?php
require_once '../headfoot/connect.php';
require_once '../Data/DataRap.php';
require_once '../Data/DataLichChieu.php';
require_once '../Data/PhimData.php';

$dataRap = new DataRap($conn);
$dataLich = new DataLichChieu($conn);
$dataPhim = new PhimData($conn);
$dsPhim = $dataPhim->getAllMovies();
$dsRap = $dataRap->getAll();
session_start();

/* ===== DANH MỤC PHIM ===== */
$categories = [
    'hai-huoc' => 'HÀI HƯỚC',
    'tinh-cam' => 'TÌNH CẢM',
    'tam-ly'   => 'TÂM LÝ',
    'hanh-dong'=> 'HÀNH ĐỘNG',
    'sci-fi'   => 'KHOA HỌC VIỄN TƯỞNG',
    'kinh-di' => 'KINH DỊ',
    'hoat-hinh' => 'HOẠT HÌNH'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách phim</title>

    <link rel="stylesheet" href="../headfoot/header.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../headfoot/header.css">
     <link rel="stylesheet" href="phim.css">
     <link rel="stylesheet" href="popup.css">

</head>

<body>

<?php include "../headfoot/header.php"; ?>

<main class="container movie-list">

    <!-- ===== FILTER BAR ===== --> 
        <div class="movie-filter mb-4">
       <div class="filter-left">
        <i class="fa-solid fa-film cinema-icon"></i>
        <span class="filter-title">Danh mục</span>
     
    </div>

                <?php foreach ($categories as $id => $name): ?>
                   <a href="?category=<?= urlencode($name) ?>#<?= $id ?>" class="filter-item">
  <?= $name ?>
</a>

                <?php endforeach; ?>
                <form method="GET" class="filter-right">
  <input
    type="text"
    name="search"
    placeholder="Search.."
    class="search-input"
    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
  >
  <button type="submit" class="search-btn">
    <i class="fa-solid fa-magnifying-glass"></i>
  </button>
</form>

        </div>

    <!-- ===== MOVIE SECTIONS ===== -->
   <?php
$search = $_GET['search'] ?? '';
?>

<?php if (!empty($search)): ?>

    <!-- ================= SEARCH RESULT ================= -->
    <section class="movie-section mb-5">
        <div class="category-title mb-3">
            <span>Kết quả tìm kiếm cho: "<?= htmlspecialchars($search) ?>"</span>
        </div>

        <div class="row">
            <?php
            $stmt = $conn->prepare(
                "SELECT * FROM qlphim WHERE TenPhim LIKE ?"
            );
            $like = "%$search%";
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $result = $stmt->get_result();
            ?>

            <?php if ($result->num_rows === 0): ?>
                <p class="text-muted">Không tìm thấy phim phù hợp.</p>
            <?php endif; ?>

            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="movie-card h-100">
                        <a href="detail_phim.php?id=<?= $row['IDPhim'] ?>">
                            <img class="poster"
                                 src="../images/movie/<?= htmlspecialchars($row['Poster']) ?>"
                                 alt="<?= htmlspecialchars($row['TenPhim']) ?>">
                        </a>

                        <h5><?= htmlspecialchars($row['TenPhim']) ?></h5>

                        <p class="movie-meta mb-1">
                            <?= htmlspecialchars($row['TheLoai']) ?> • 
                            <?= $row['ThoiLuong'] ?> phút
                        </p>

                        <p class="small mb-2">
                            🌍 <?= htmlspecialchars($row['QuocGia']) ?><br>
                            ⭐ <?= $row['Rate'] ?? 'Chưa đánh giá' ?>
                        </p>

                        <a class="btn btn-danger w-100" href="#">
                            Mua vé
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

<?php else: ?>

    <!-- ================= NORMAL CATEGORY VIEW ================= -->
    <?php foreach ($categories as $id => $name): ?>

        <section id="<?= $id ?>" class="movie-section mb-5">
            <div class="category-title mb-3">
                <span><?= $name ?></span>
            </div>

            <div class="row">
                <?php
                $stmt = $conn->prepare(
                    "SELECT * FROM qlphim WHERE TheLoai LIKE ?"
                );
                $like = "%$name%";
                $stmt->bind_param("s", $like);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="movie-card h-100">
                            <a href="detail_phim.php?id=<?= $row['IDPhim'] ?>">
                                <img class="poster"
                                     src="../images/movie/<?= htmlspecialchars($row['Poster']) ?>"
                                     alt="<?= htmlspecialchars($row['TenPhim']) ?>">
                            </a>

                            <h5><?= htmlspecialchars($row['TenPhim']) ?></h5>

                            <p class="movie-meta mb-1">
                                <?= htmlspecialchars($row['TheLoai']) ?> • 
                                <?= $row['ThoiLuong'] ?> phút
                            </p>

                            <p class="small mb-2">
                                🌍 <?= htmlspecialchars($row['QuocGia']) ?><br>
                                ⭐ <?= $row['Rate'] ?? 'Chưa đánh giá' ?>
                            </p>

                            <a
                    href="ChonRap.php?idphim=<?= $row['IDPhim'] ?>"
                     class="btn btn-danger w-100"
                            > Mua vé
                             </a>


                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>

    <?php endforeach; ?>

<?php endif; ?>
  
</main>


<button id="scrollToTopButton" onclick="window.scrollTo({top:0,behavior:'smooth'})">
     <i class="fas fa-arrow-up"></i> </button>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">       
     </script>
    </body> </html>

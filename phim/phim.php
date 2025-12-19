<?php
require_once  '../headfoot/connect.php';
session_start();

$sql = "SELECT * FROM movie";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách phim</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="phim.css">
    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
</head>

<body>

<?php include "../headfoot/header.php"; ?>

<!-- MAIN -->
<main class="container movie-list">
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-3 col-sm-6 col">
                <div class="movie-card">
                    <a href="detail_phim.php?id=<?= $row['movie_id'] ?>">
                        <img
                            class="poster"
                            src="../images/movie/<?= htmlspecialchars($row['poster']) ?>"
                            alt="<?= htmlspecialchars($row['title_movie']) ?>"
                        >
                    </a>

                    <h5><?= htmlspecialchars($row['title_movie']) ?></h5>
                    <p><?= htmlspecialchars($row['genre']) ?> • <?= $row['duration'] ?> phút</p>

                    <a class="btn btn-danger w-100" href="#">Mua vé</a>
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

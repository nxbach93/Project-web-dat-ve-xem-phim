<?php
require "../headfoot/connect.php";

$id = $_GET['id'];
$sql = "SELECT * FROM movie WHERE movie_id = $id";
$movie = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $movie['title_movie']; ?></title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="phim_detail.css">
</head>

<body>
<?php include "../headfoot/header.php"; ?>

<main class="movie-detail">
    <img class="movie-poster" src="../images/movie/<?= $movie['poster'] ?>">

    <div class="movie-info">       
            <h2><?= $movie['title_movie'] ?></h2>
            <p>🎭 Thể loại: <?= $movie['genre'] ?></p>
            <p>📅 Ngày ra mắt: <?= $movie['release_date'] ?></p>
            <p>⏱ Thời lượng: <?= $movie['duration'] ?> phút</p>
            <p>🎬 Đạo diễn: <?= $movie['film_director'] ?></p>
            <p><?= $movie['description_movie'] ?></p>
    </div>
</main>




</body>
</html>

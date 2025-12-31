<?php
require "../headfoot/connect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: phim.php");
    exit();
}

$movie_id = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
$content  = isset($_POST['content']) ? trim($_POST['content']) : '';

if ($movie_id <= 0 || $content === '') {
    header("Location: detail_phim.php?id=" . $movie_id);
    exit();
}

if (mb_strlen($content) > 500) {
    $content = mb_substr($content, 0, 500);
}

$avatars = [
    "avatar1.png",
    "avatar2.png",
    "avatar3.jpg",
    "avatar4.jpg"
];

$avatar = $avatars[array_rand($avatars)];

$sql = "
    INSERT INTO comment (IDPhim, Content, Avatar)
    VALUES (?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $movie_id, $content, $avatar);
$stmt->execute();

header("Location: detail_phim.php?id=" . $movie_id);
exit();

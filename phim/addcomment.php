<?php
require "../headfoot/connect.php";

/* ===== CHỈ CHO PHÉP POST ===== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: phim.php");
    exit();
}

/* ===== LẤY DỮ LIỆU ===== */
$movie_id = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
$content  = isset($_POST['content']) ? trim($_POST['content']) : '';

/* ===== VALIDATE ===== */
if ($movie_id <= 0 || $content === '') {
    header("Location: detail_phim.php?id=" . $movie_id);
    exit();
}

/* ===== GIỚI HẠN ĐỘ DÀI COMMENT (CHỐNG SPAM) ===== */
if (mb_strlen($content) > 500) {
    $content = mb_substr($content, 0, 500);
}

/* ===== DANH SÁCH AVATAR ===== */
$avatars = [
    "avatar1.png",
    "avatar2.png",
    "avatar3.jpg",
    "avatar4.jpg"
];

/* ===== RANDOM AVATAR ===== */
$avatar = $avatars[array_rand($avatars)];

/* ===== INSERT COMMENT ===== */
$sql = "
    INSERT INTO comment (IDPhim, Content, Avatar)
    VALUES (?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $movie_id, $content, $avatar);
$stmt->execute();

/* ===== QUAY LẠI TRANG CHI TIẾT PHIM ===== */
header("Location: detail_phim.php?id=" . $movie_id);
exit();

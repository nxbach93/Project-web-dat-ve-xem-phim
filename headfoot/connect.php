<?php
$conn = new mysqli("192.168.56.1", "root", "", "testdbproject");
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");


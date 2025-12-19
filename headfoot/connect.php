<?php
$conn = new mysqli("localhost", "root", "", "projecttest");
if ($conn->connect_error) {
    die("Lỗi kết nối: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");


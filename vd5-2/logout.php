<?php
session_start();

// Hủy toàn bộ session
session_destroy();

// Chuyển hướng về trang login
header("Location: login.php");
exit();
?>

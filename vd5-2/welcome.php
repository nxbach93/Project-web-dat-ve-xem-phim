<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chào mừng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            margin-top: 80px;
        }

        p {
            text-align: center;
            margin-bottom: 20px;
        }

        a {
            display: block;
            width: 120px;
            margin: 0 auto;
            text-align: center;
            padding: 8px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        a:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>Chào mừng, <?php echo $_SESSION['username']; ?>!</h2>
    <p>Bạn đã đăng nhập thành công.</p>
    <a href="logout.php">Đăng xuất</a>
</body>
</html>
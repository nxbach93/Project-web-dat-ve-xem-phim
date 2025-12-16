<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $_SESSION['username'] = $_POST['username'];
   header("Location: welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }

        form {
            width: 300px;
            margin: 100px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 8px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form method="POST" action="">
        <label>Nhập tên của bạn:</label>
        <input type="text" name="username" required>
        <button type="submit">Đăng Nhập</button>

    </form>
</body>
</html>

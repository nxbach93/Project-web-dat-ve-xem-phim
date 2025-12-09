<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    <title>Dãy số 1 đến 100</title>
    <style>
        .numbers { line-height: 1.8; font-size: 18px; font-family: Arial, sans-serif; }
        /* Số chẵn: in đậm, màu đỏ */
        .even { color: red; font-weight: bold; }
        /* Số lẻ: in đậm, nghiêng, màu xanh */
        .odd  { color: green; font-weight: bold; font-style: italic; }
    </style>
    </head>
    <body>
        <p>In các số từ 1 đến 100, với số chẵn in màu xanh, nghiêng còn số lẻ in màu đỏ.</p>
        <hr>

        <br>
        <div class="numbers">
    <?php
        // In các số từ 1 đến 100
        for ($i = 1; $i <= 100; $i++) {
            $class = ($i % 2 === 0) ? 'even' : 'odd';
            echo "<span class=\"$class\">$i</span>";
            // ngăn cách bằng khoảng trắng, xuống dòng sau mỗi 10 số để dễ nhìn
            if ($i < 100) echo ' ';
            if ($i % 10 === 0) echo "<br>";
        }
    ?>
    </div>
    </body>
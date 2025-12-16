<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kết nối csdl sinh viên</title>
</head>
<body>
    <h2>Danh sách sinh viên</h2>
    <?php 
    $conn = mysqli_connect("localhost", "root", "", "test");

    // Kiểm tra kết nối
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    mysqli_set_charset($conn, "utf8mb4");

    //tạo câu truy vấn
    $sql = "Select id, ho_ten, ngay_sinh, gioi_tinh from dlsv";
    //thực thi câu lệnh truy vấn 
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) >0) 
    {
        echo "<table border ='1' cellpadding='10' cellspacing='0'>";
        echo "<tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Ngày Sinh</th>
                <th>Giới Tính</th>
             </tr>";

        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" .$row["id"] ."</td>";
            echo "<td>" .$row["ho_ten"] ."</td>";
            echo "<td>" .$row["ngay_sinh"] ."</td>";
            echo "<td>" .$row["gioi_tinh"] ."</td>";
            echo "</tr>";
        }
       echo  "</table>";
    }
    else {
        echo " Không có record nào !";
    }
    //ngắt kế nối
    mysqli_close($conn);
    
    ?>
</body>
</html>
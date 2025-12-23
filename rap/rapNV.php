<?php
session_start();
// Nhúng file kết nối từ thư mục headfoot
include('../headfoot/connect.php'); 

// THÊM / SỬA
if (isset($_POST['save'])) {
    $id = $_POST['IDRap'];
    $ten = $_POST['TenRap'];
    $diachi = $_POST['DiaChi'];
    $hotline = $_POST['Hotline'];
    $gioithieu = $_POST['GioiThieu'];

    if ($id == "") {
        $conn->query("INSERT INTO rap (TenRap, DiaChi, Hotline, GioiThieu)
                      VALUES ('$ten','$diachi','$hotline','$gioithieu')");
    } else {
        $conn->query("UPDATE rap SET 
                      TenRap='$ten',
                      DiaChi='$diachi',
                      Hotline='$hotline',
                      GioiThieu='$gioithieu'
                      WHERE IDRap=$id");
    }
    header("Location: rapNV.php");
    exit();
}

// XÓA
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM rap WHERE IDRap=".$_GET['delete']);
    header("Location: rapNV.php");
    exit();
}

// SỬA
$edit = null;
    if (isset($_GET['edit'])) {
        $edit = $conn->query("SELECT * FROM rap WHERE IDRap=".$_GET['edit'])->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hệ Thống Rạp - Cinema Center</title>
    <link rel="stylesheet" href="../headfoot/header.css">
    <link rel="stylesheet" href="rapNV.css">
</head>
<body>

<?php include('../headfoot/headerNV.php'); ?>

<main class="home">
    <h2 class="section-title">Quản lý Rạp Chiếu</h2>

    <!-- FORM THÊM / SỬA -->
     <form method="post" class="rap-form">
        <input type="hidden" name="IDRap" value="<?= $edit['IDRap'] ?? '' ?>">

        <input type="text" name="TenRap" placeholder="Tên rạp"
            value="<?= $edit['TenRap'] ?? '' ?>" required>

        <input type="text" name="DiaChi" placeholder="Địa chỉ"
            value="<?= $edit['DiaChi'] ?? '' ?>" required>

        <input type="text" name="Hotline" placeholder="Hotline"
            value="<?= $edit['Hotline'] ?? '' ?>" required>

        <textarea name="GioiThieu" placeholder="Giới thiệu rạp"><?= $edit['GioiThieu'] ?? '' ?></textarea>

        <button type="submit" name="save">
            <?= isset($edit) ? 'Cập nhật rạp' : 'Thêm rạp' ?>
        </button>
    </form>
    <?php
    $sql_rap = "SELECT * FROM rap";
    $result_rap = $conn->query($sql_rap);

    if ($result_rap && $result_rap->num_rows > 0) {
        while($rap = $result_rap->fetch_assoc()) {
            $idRap = $rap['IDRap'];
            $map_url = "https://www.google.com/maps/search/" . urlencode($rap['DiaChi']);
            ?>

            <div class="cinema-item">
                <div class="cinema-details">
                    <h3><?php echo $rap['TenRap']; ?></h3>
                    <p class="info-row"><strong>📍 Địa chỉ:</strong> <a href="<?php echo $map_url; ?>" target="_blank"><?php echo $rap['DiaChi']; ?></a></p>
                    <p class="info-row"><strong>📞 Hotline:</strong> <?php echo $rap['Hotline']; ?></p>
                    <p class="info-row"><strong>👏Giới thiệu:</strong> <?php echo $rap['GioiThieu']; ?></p>
                </div>

                <div class="cinema-current-movie">
                        <a class="btn-suaxoa" href="?edit=<?= $rap['IDRap'] ?>">✏ Sửa</a>
                        <a class="btn-suaxoa" href="?delete=<?= $rap['IDRap'] ?>"
                        onclick="return confirm('Xóa rạp này?')">🗑 Xóa</a>
                </div>
            </div>

            <?php
        }
    } else {
        echo '<p>Không tìm thấy rạp nào.</p>';
    }
    $conn->close();
    ?>
</main>

</body>
</html>
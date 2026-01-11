<?php
require "../headfoot/connect.php";

$giaves = $conn->query("SELECT * FROM thongtinve ORDER BY LoaiVe");

$doanuongs = $conn->query("SELECT * FROM doanuong ORDER BY TenDoAnUong");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Giá Vé & Đồ Ăn Uống</title>
<link rel="stylesheet" href="admin_giave_modal.css">
</head>
<body>
<div class="container">
    <h1>🎟️ Quản lý Giá Vé & Đồ Ăn Uống</h1>

    <!-- ===== GIÁ VÉ ===== -->
    <h2>🎫 Giá Vé</h2>
    <button class="btn add" onclick="openModal('add_ve')">➕ Thêm giá vé</button>
    <table>
        <thead>
            <tr>
                <th>Loại vé</th>
                <th>Ngày thường</th>
                <th>Ưu đãi</th>
                <th>Ngày lễ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if($giaves->num_rows>0): ?>
            <?php while($g=$giaves->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($g['LoaiVe']) ?></td>
                <td><?= number_format($g['GiaNgayThuong']) ?> đ</td>
                <td><?= number_format($g['GiaUuDai']) ?> đ</td>
                <td><?= number_format($g['GiaNgayLe']) ?> đ</td>
                <td>
                    <button class="btn edit" onclick="openModal('edit_ve', <?= $g['IDVe'] ?>, '<?= htmlspecialchars($g['LoaiVe'],ENT_QUOTES) ?>', <?= $g['GiaNgayThuong'] ?>, <?= $g['GiaUuDai'] ?>, <?= $g['GiaNgayLe'] ?>)">✏️ Sửa</button>
                    <a href="admin_process.php?action=delete_ve&id=<?= $g['IDVe'] ?>" class="btn delete" onclick="return confirm('Xác nhận xóa?')">🗑️ Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5" class="empty">Chưa có dữ liệu giá vé</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- ===== ĐỒ ĂN UỐNG ===== -->
    <h2>🍿 Đồ Ăn Uống</h2>
    <button class="btn add" onclick="openModal('add_do')">➕ Thêm đồ ăn</button>
    <table>
        <thead>
            <tr>
                <th>Tên đồ ăn</th>
                <th>Giá thường</th>
                <th>Giá ưu đãi</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php if($doanuongs->num_rows>0): ?>
            <?php while($d=$doanuongs->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($d['TenDoAnUong']) ?></td>
                <td><?= number_format($d['Gia']) ?> đ</td>
                <td><?= number_format($d['GiaUuDai']) ?> đ</td>
                <td>
                    <button class="btn edit" onclick="openModal('edit_do', <?= $d['IDDoAnUong'] ?>, '<?= htmlspecialchars($d['TenDoAnUong'],ENT_QUOTES) ?>', <?= $d['Gia'] ?>, <?= $d['GiaUuDai'] ?>)">✏️ Sửa</button>
<a href="admin_process.php?action=delete_do&id=<?= $d['IDDoAnUong'] ?>" class="btn delete" onclick="return confirm('Xác nhận xóa?')">🗑️ Xóa</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4" class="empty">Chưa có dữ liệu đồ ăn uống</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2 id="modal-title">Thêm</h2>
        <form id="modal-form" method="post" action="admin_process.php">
            <input type="hidden" name="action" id="form-action" value="">
            <input type="hidden" name="id" id="form-id" value="">

            <label id="label-name">Loại vé / Tên đồ ăn:</label>
            <input type="text" name="TenLoai" id="TenLoai" required>

            <label id="label-gia1">Giá ngày thường:</label>
            <input type="number" name="Gia1" id="Gia1" required>

            <label id="label-gia2">Giá ưu đãi:</label>
            <input type="number" name="Gia2" id="Gia2" required>

            <label id="label-gia3">Giá ngày lễ:</label>
            <input type="number" name="Gia3" id="Gia3">

            <button type="submit" id="submit-btn">Thêm</button>
        </form>
    </div>
</div>

<script>
function openModal(action, id=0, Ten='', Gia1=0, Gia2=0, Gia3=0){
    document.getElementById('modal').style.display = 'block';
    document.getElementById('form-action').value = action;
    document.getElementById('form-id').value = id;

    document.getElementById('TenLoai').value = Ten;
    document.getElementById('Gia1').value = Gia1;
    document.getElementById('Gia2').value = Gia2;

    if(action==='add_ve' || action==='edit_ve'){
        document.getElementById('modal-title').innerText = action==='add_ve' ? '➕ Thêm Giá Vé' : '✏️ Sửa Giá Vé';
        document.getElementById('Gia3').style.display='block';
        document.getElementById('label-gia3').style.display='block';
        document.getElementById('Gia3').value = Gia3;
        document.getElementById('submit-btn').innerText = action==='add_ve' ? 'Thêm' : 'Cập nhật';
    } else { // đồ ăn uống
        document.getElementById('modal-title').innerText = action==='add_do' ? '➕ Thêm Đồ Ăn' : '✏️ Sửa Đồ Ăn';
        document.getElementById('Gia3').style.display='none';
        document.getElementById('label-gia3').style.display='none';
        document.getElementById('submit-btn').innerText = action==='add_do' ? 'Thêm' : 'Cập nhật';
    }
}

function closeModal(){ document.getElementById('modal').style.display='none'; }

window.onclick = function(event){
    if(event.target == document.getElementById('modal')){
        closeModal();
    }
}
</script>
</body>
</html>
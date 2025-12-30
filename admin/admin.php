<?php
require_once '../headfoot/connect.php';

// ===== Lấy danh sách rạp =====
$rap_rs = $conn->query("SELECT IDRap, TenRap FROM rap ORDER BY TenRap ASC");

// ===== Lọc rạp nếu có =====
$filterRap = isset($_GET['IDRap']) ? intval($_GET['IDRap']) : 0;

if($filterRap){
    $lichchieu_rs = $conn->query("
        SELECT l.IDLichChieu, p.TenPhim, r.TenRap, l.NgayChieu, l.GioChieu
        FROM qllichchieu l
        JOIN qlphim p ON l.IDPhim = p.IDPhim
        JOIN rap r ON l.IDRap = r.IDRap
        WHERE l.IDRap = $filterRap
        ORDER BY l.NgayChieu, l.GioChieu ASC
    ");
} else {
    $lichchieu_rs = $conn->query("
        SELECT l.IDLichChieu, p.TenPhim, r.TenRap, l.NgayChieu, l.GioChieu
        FROM qllichchieu l
        JOIN qlphim p ON l.IDPhim = p.IDPhim
        JOIN rap r ON l.IDRap = r.IDRap
        ORDER BY l.NgayChieu, l.GioChieu ASC
    ");
}

// ===== Xóa lịch chiếu =====
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM qllichchieu WHERE IDLichChieu=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']."?IDRap=".$filterRap);
    exit;
}

// ===== Thêm lịch chiếu =====
if(isset($_POST['add_lichchieu'])){
    $idPhim = intval($_POST['IDPhim']);
    $idRap = intval($_POST['IDRap']);
    $ngay = $_POST['NgayChieu'];
    $gio = $_POST['GioChieu'];
    if(strlen($gio)==5) $gio .= ':00';

    $stmt = $conn->prepare("INSERT INTO qllichchieu (IDPhim, IDRap, NgayChieu, GioChieu) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $idPhim, $idRap, $ngay, $gio);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']."?IDRap=".$idRap);
    exit;
}

// ===== Sửa lịch chiếu =====
if(isset($_POST['edit_lichchieu'])){
    $id = intval($_POST['IDLichChieu']);
    $ngay = $_POST['NgayChieu'];
    $gio = $_POST['GioChieu'];
    if(strlen($gio)==5) $gio .= ':00';

    $stmt = $conn->prepare("UPDATE qllichchieu SET NgayChieu=?, GioChieu=? WHERE IDLichChieu=?");
    $stmt->bind_param("ssi", $ngay, $gio, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']."?IDRap=".$filterRap);
    exit;
}

// ===== Lấy danh sách phim =====
$phim_rs = $conn->query("SELECT IDPhim, TenPhim FROM qlphim ORDER BY TenPhim ASC");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Quản lý Lịch Chiếu</title>
<link rel="stylesheet" href="admin.css?v=1">
</head>
<body>
<div class="container">
<h1>Quản lý Lịch Chiếu</h1>

<!-- Dropdown chọn rạp -->
<form method="get" id="form-filter-rap">
    <label>Chọn rạp:</label>
    <select name="IDRap" onchange="document.getElementById('form-filter-rap').submit();">
        <option value="">-- Tất cả rạp --</option>
        <?php $rap_rs->data_seek(0); while($r = $rap_rs->fetch_assoc()): ?>
            <option value="<?php echo $r['IDRap']; ?>" <?php if($filterRap==$r['IDRap']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($r['TenRap']); ?>
            </option>
        <?php endwhile; ?>
    </select>
</form>

<button class="btn-add" onclick="openAddModal()">+ Thêm Lịch Chiếu</button>

<table>
<thead>
<tr>
<th>ID</th>
<th>Phim</th>
<th>Rạp</th>
<th>Ngày Chiếu</th>
<th>Giờ Chiếu</th>
<th>Hành Động</th>
</tr>
</thead>
<tbody>
<?php while($l = $lichchieu_rs->fetch_assoc()): ?>
<tr data-id="<?php echo $l['IDLichChieu']; ?>" data-ngay="<?php echo $l['NgayChieu']; ?>" data-gio="<?php echo $l['GioChieu']; ?>">
<td><?php echo $l['IDLichChieu']; ?></td>
<td><?php echo htmlspecialchars($l['TenPhim']); ?></td>
<td><?php echo htmlspecialchars($l['TenRap']); ?></td>
<td><?php echo $l['NgayChieu']; ?></td>
<td><?php echo $l['GioChieu']; ?></td>
<td>
<button onclick="openEditModal(this)">Sửa</button>
<a href="?delete=<?php echo $l['IDLichChieu']; ?>&IDRap=<?php echo $filterRap; ?>" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

<!-- Modal Thêm -->
<div id="modal-add" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('modal-add')">&times;</span>
<h2>Thêm Lịch Chiếu</h2>
<form method="post">
<label>Phim:</label>
<select name="IDPhim">
<?php $phim_rs->data_seek(0); while($p = $phim_rs->fetch_assoc()): ?>
<option value="<?php echo $p['IDPhim']; ?>"><?php echo htmlspecialchars($p['TenPhim']); ?></option>
<?php endwhile; ?>
</select>
<label>Rạp:</label>
<select name="IDRap">
<?php $rap_rs->data_seek(0); while($r = $rap_rs->fetch_assoc()): ?>
<option value="<?php echo $r['IDRap']; ?>" <?php if($filterRap==$r['IDRap']) echo 'selected'; ?>>
<?php echo htmlspecialchars($r['TenRap']); ?></option>
<?php endwhile; ?>
</select>
<label>Ngày & giờ chiếu:</label>
<div class="inline-inputs">
<input type="date" name="NgayChieu" required>
<input type="time" name="GioChieu" value="19:00" required>
</div>
<button type="submit" name="add_lichchieu">Thêm</button>
</form>
</div>
</div>

<!-- Modal Sửa -->
<div id="modal-edit" class="modal">
<div class="modal-content">
<span class="close" onclick="closeModal('modal-edit')">&times;</span>
<h2>Sửa Lịch Chiếu</h2>
<form method="post" id="form-edit">
<input type="hidden" name="IDLichChieu" id="edit-id">
<label>Ngày & giờ chiếu:</label>
<div class="inline-inputs">
<input type="date" name="NgayChieu" id="edit-ngay" required>
<input type="time" name="GioChieu" id="edit-gio" required>
</div>
<button type="submit" name="edit_lichchieu">Cập nhật</button>
</form>
</div>
</div>

<script>
function openAddModal(){ document.getElementById('modal-add').style.display='flex'; document.body.style.overflow='hidden'; }
function openEditModal(btn){
    const tr = btn.closest('tr');
    document.getElementById('edit-id').value = tr.dataset.id;
    document.getElementById('edit-ngay').value = tr.dataset.ngay;
    document.getElementById('edit-gio').value = tr.dataset.gio;
    document.getElementById('modal-edit').style.display='flex';
    document.body.style.overflow='hidden';
}
function closeModal(id){ document.getElementById(id).style.display='none'; document.body.style.overflow='auto'; }
document.addEventListener('keydown', e=>{ if(e.key==="Escape"){ closeModal('modal-add'); closeModal('modal-edit'); } });
</script>
</body>
</html>

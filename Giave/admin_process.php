<?php
$conn = new mysqli("localhost", "root", "", "testdbproject");
$conn->set_charset("utf8mb4");

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// ===== GIÁ VÉ =====
if($action=='add_ve'){
    $TenLoai = $_POST['TenLoai'];
    $Gia1 = $_POST['Gia1'];
    $Gia2 = $_POST['Gia2'];
    $Gia3 = $_POST['Gia3'] ?? 0;

    $stmt = $conn->prepare("INSERT INTO thongtinve (LoaiVe, GiaNgayThuong, GiaUuDai, GiaNgayLe) VALUES (?,?,?,?)");
    $stmt->bind_param("siii", $TenLoai, $Gia1, $Gia2, $Gia3);
    $stmt->execute();

    header("Location: admin_giave_doanuong_modal.php");
    exit;
}

if($action=='edit_ve'){
    $id = $_POST['id'];
    $TenLoai = $_POST['TenLoai'];
    $Gia1 = $_POST['Gia1'];
    $Gia2 = $_POST['Gia2'];
    $Gia3 = $_POST['Gia3'] ?? 0;

    $stmt = $conn->prepare("UPDATE thongtinve SET LoaiVe=?, GiaNgayThuong=?, GiaUuDai=?, GiaNgayLe=? WHERE IDVe=?");
    $stmt->bind_param("siiii", $TenLoai, $Gia1, $Gia2, $Gia3, $id);
    $stmt->execute();

    header("Location: admin_giave_doanuong_modal.php");
    exit;
}

if($action=='delete_ve'){
    $id = $_GET['id'];
    if(isset($_GET['all'])){
        $row = $conn->query("SELECT LoaiVe FROM thongtinve WHERE IDVe=$id")->fetch_assoc();
        $LoaiVe = $row['LoaiVe'];
        $conn->query("DELETE FROM thongtinve WHERE LoaiVe='$LoaiVe'");
    } else {
        $conn->query("DELETE FROM thongtinve WHERE IDVe=$id");
    }
    header("Location: admin_giave_doanuong_modal.php");
    exit;
}

// ===== ĐỒ ĂN UỐNG =====
if($action=='add_do'){
    $TenLoai = $_POST['TenLoai'];
    $Gia1 = $_POST['Gia1'];
    $Gia2 = $_POST['Gia2'];

    $stmt = $conn->prepare("INSERT INTO doanuong (TenDoAnUong, Gia, GiaUuDai) VALUES (?,?,?)");
    $stmt->bind_param("sii", $TenLoai, $Gia1, $Gia2);
    $stmt->execute();

    header("Location: admin_giave_doanuong_modal.php");
    exit;
}

if($action=='edit_do'){
    $id = $_POST['id'];
    $TenLoai = $_POST['TenLoai'];
    $Gia1 = $_POST['Gia1'];
    $Gia2 = $_POST['Gia2'];

    $stmt = $conn->prepare("UPDATE doanuong SET TenDoAnUong=?, Gia=?, GiaUuDai=? WHERE IDDoAnUong=?");
    $stmt->bind_param("siii", $TenLoai, $Gia1, $Gia2, $id);
    $stmt->execute();

    header("Location: admin_giave_doanuong_modal.php");
    exit;
}

if($action=='delete_do'){
    $id = $_GET['id'];
    $conn->query("DELETE FROM doanuong WHERE IDDoAnUong=$id");
    header("Location: admin_giave_doanuong_modal.php");
    exit;
}
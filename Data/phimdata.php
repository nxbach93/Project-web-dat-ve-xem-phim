<?php


class PhimData {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả phim
  public function getAllMovies() {
    $sql = "SELECT * FROM qlphim ORDER BY IDPhim DESC";
    $result = $this->conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


    // Lấy phim theo ID
    public function getMovieById($idPhim) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM qlphim WHERE IDPhim = ?"
        );
        $stmt->bind_param("i", $idPhim);
       $stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$stmt->close();
return $data;

    }

    // Thêm phim
    public function addMovie($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO qlphim
            (TenPhim, Thoiluong, TheLoai, QuocGia, NgayKhoiChieu, Poster, DaoDien, DienVien, TomTat, Rate, TongGhe)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "sissssssssi",
            $data['TenPhim'],
            $data['Thoiluong'],
            $data['TheLoai'],
            $data['QuocGia'],
            $data['NgayKhoiChieu'],
            $data['Poster'],
            $data['DaoDien'],
            $data['DienVien'],
            $data['TomTat'],
            $data['Rate'],
            $data['TongGhe']
        );

        return $stmt->execute();
    }

    // Cập nhật phim
    public function updateMovie($idPhim, $data) {
        $stmt = $this->conn->prepare("
            UPDATE qlphim SET
                TenPhim = ?,
                Thoiluong = ?,
                TheLoai = ?,
                QuocGia = ?,
                NgayKhoiChieu = ?,
                Poster = ?,
                DaoDien = ?,
                DienVien = ?,
                TomTat = ?,
                Rate = ?,
                TongGhe = ?
            WHERE IDPhim = ?
        ");

        $stmt->bind_param(
            "sissssssssii",
            $data['TenPhim'],
            $data['Thoiluong'],
            $data['TheLoai'],
            $data['QuocGia'],
            $data['NgayKhoiChieu'],
            $data['Poster'],
            $data['DaoDien'],
            $data['DienVien'],
            $data['TomTat'],
            $data['Rate'],
            $data['TongGhe'],
            $idPhim
        );

        return $stmt->execute();
    }

    // Xóa phim
    public function deleteMovie($idPhim) {
        $stmt = $this->conn->prepare(
            "DELETE FROM qlphim WHERE IDPhim = ?"
        );
        $stmt->bind_param("i", $idPhim);
        return $stmt->execute();
    }
}

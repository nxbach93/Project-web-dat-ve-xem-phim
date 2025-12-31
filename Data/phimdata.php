<?php


class PhimData {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

  public function getAllMovies() {
    $sql = "SELECT * FROM qlphim ORDER BY IDPhim DESC";
    $result = $this->conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}


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

    public function deleteMovie($idPhim) {
        $stmt = $this->conn->prepare(
            "DELETE FROM qlphim WHERE IDPhim = ?"
        );
        $stmt->bind_param("i", $idPhim);
        return $stmt->execute();
    }
}

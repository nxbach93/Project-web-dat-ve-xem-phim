<?php
class DataLichChieu {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getLichChieuTheoNgay($idRap, $idPhim, $ngay) {
        $sql = "
            SELECT 
                lc.IDLichChieu,
                lc.GioChieu,
                r.TenRap
            FROM qllichchieu lc
            JOIN rap r ON lc.IDRap = r.IDRap
            WHERE lc.IDRap = ?
              AND lc.IDPhim = ?
              AND lc.NgayChieu = ?
            ORDER BY lc.GioChieu
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $idRap, $idPhim, $ngay);
        $stmt->execute();

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data;
    }

   public function getDanhSachNgay($idRap, $idPhim) {
    $sql = "
        SELECT DISTINCT DATE(NgayChieu) AS Ngay
        FROM qllichchieu
        WHERE IDRap = ? AND IDPhim = ?
        ORDER BY Ngay
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ii", $idRap, $idPhim);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $result;
}



    public function getNgayChieu($idRap, $idPhim) {
        $sql = "
            SELECT DISTINCT DATE(NgayChieu) AS Ngay
            FROM qllichchieu
            WHERE IDRap = ? AND IDPhim = ?
            ORDER BY Ngay
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $idRap, $idPhim);
        $stmt->execute();

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data;
    }


    public function getGioChieu($idRap, $idPhim, $ngay) {
        $sql = "
            SELECT *
            FROM qllichchieu
            WHERE IDRap = ?
              AND IDPhim = ?
              AND DATE(NgayChieu) = ?
            ORDER BY GioChieu
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $idRap, $idPhim, $ngay);
        $stmt->execute();

        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data;
    }

    public function tinhGheTrong($idLichChieu) {
        $sql = "
            SELECT 
                p.TongGhe - IFNULL(COUNT(v.IDHoaDonDatVe), 0) AS GheTrong
            FROM qllichchieu lc
            JOIN qlphim p ON lc.IDPhim = p.IDPhim
            LEFT JOIN qldatve v ON lc.IDLichChieu = v.IDLichChieu
            WHERE lc.IDLichChieu = ?
            GROUP BY p.TongGhe
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idLichChieu);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row['GheTrong'] ?? 0;
    }
}

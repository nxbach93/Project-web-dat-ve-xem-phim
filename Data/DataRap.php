<?php
class DataRap {
    private mysqli $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả rạp
    public function getAll(): array {
        $sql = "SELECT * FROM rap";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        return $data;
    }

    // 🔥 Lấy rạp theo ID (BẮT BUỘC cho XacNhan.php)
    public function getById(int $idRap): ?array {
        $sql = "SELECT * FROM rap WHERE IDRap = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idRap);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        $stmt->close();
        return $result ?: null;
    }
}

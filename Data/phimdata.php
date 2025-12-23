<?php
require_once  '../headfoot/connect.php';

class MovieDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy toàn bộ phim
    public function getAllMovies() {
        $sql = "SELECT * FROM movie ORDER BY movie_id DESC";
        return $this->conn->query($sql);
    }

    // Lấy phim theo ID
    public function getMovieById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM movie WHERE movie_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm phim
    public function addMovie($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO movie 
            (title_movie, release_date, duration, genre, poster, rating, film_director, description_movie)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssissdss",
            $data['title_movie'],
            $data['release_date'],
            $data['duration'],
            $data['genre'],
            $data['poster'],
            $data['rating'],
            $data['film_director'],
            $data['description_movie']
        );

        return $stmt->execute();
    }

    // Cập nhật phim
    public function updateMovie($id, $data) {
        $stmt = $this->conn->prepare("
            UPDATE movie SET
                title_movie = ?,
                release_date = ?,
                duration = ?,
                genre = ?,
                poster = ?,
                rating = ?,
                film_director = ?,
                description_movie = ?
            WHERE movie_id = ?
        ");

        $stmt->bind_param(
            "ssissdssi",
            $data['title_movie'],
            $data['release_date'],
            $data['duration'],
            $data['genre'],
            $data['poster'],
            $data['rating'],
            $data['film_director'],
            $data['description_movie'],
            $id
        );

        return $stmt->execute();
    }

    // Xóa phim
    public function deleteMovie($id) {
        $stmt = $this->conn->prepare("DELETE FROM movie WHERE movie_id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

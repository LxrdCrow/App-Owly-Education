<?php
require_once '../config/database.php';

class Course {
    private $conn;
    private $table = 'courses';  

    public function __construct() {
        $database = new Database();  
        $this->conn = $database->getConnection();  
    }

    
    public function getAllCourses() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function createCourse($name, $subjects, $seats) {
        $query = "INSERT INTO " . $this->table . " (name, subjects, seats) VALUES (:name, :subjects, :seats)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subjects', $subjects);
        $stmt->bindParam(':seats', $seats);
        return $stmt->execute();
    }

   
    public function updateCourse($id, $name, $subjects, $seats) {
        $query = "UPDATE " . $this->table . " SET name = :name, subjects = :subjects, seats = :seats WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':subjects', $subjects);
        $stmt->bindParam(':seats', $seats);
        return $stmt->execute();
    }

    
    public function deleteCourse($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

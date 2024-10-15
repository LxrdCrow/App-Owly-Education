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

    public function getFilteredCourses($subject_ids = null, $name = null, $available_slots = null, $limit = 10, $offset = 0) {
        $query = "SELECT c.* FROM " . $this->table . " c";
        
        if ($subject_ids) {
            $query .= " INNER JOIN course_subject cs ON c.id = cs.course_id WHERE cs.subject_id IN (" . implode(',', array_fill(0, count($subject_ids), '?')) . ")";
        } else {
            $query .= " WHERE 1=1";
        }
    
        if ($name) {
            $query .= " AND c.name LIKE ?";
        }
    
        if ($available_slots) {
            $query .= " AND c.available_slots >= ?";
        }
    
        $query .= " LIMIT ? OFFSET ?";
    
        $stmt = $this->conn->prepare($query);
        

        $params = [];
        if ($subject_ids) {
            foreach ($subject_ids as $id) {
                $params[] = $id;
            }
        }
        if ($name) {
            $params[] = '%' . $name . '%';
        }
        if ($available_slots) {
            $params[] = $available_slots;
        }
    
        
        $params[] = $limit;
        $params[] = $offset;
    
        $stmt->execute($params);
    
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

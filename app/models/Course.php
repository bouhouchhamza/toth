<?php

require_once __DIR__ . '/../core/Database.php';

class Course {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public static function getAll() {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM courses ORDER BY title";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function findById($id) {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM courses WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function create($title, $description) {
        $sql = "INSERT INTO courses (title, description) VALUES (:title, :description)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    public function update($id, $title, $description) {
        $sql = "UPDATE courses SET title = :title, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
<?php

require_once __DIR__ . '/../core/Database.php';

class Student {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function register($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO students (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        
        return $stmt->execute();
    }

    public function authenticate($email, $password) {
        $sql = "SELECT * FROM students WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $student = $stmt->fetch();
        
        if ($student && password_verify($password, $student['password'])) {
            return $student;
        }
        
        return false;
    }

    public static function findById($id) {
        $db = Database::getInstance();
        
        $sql = "SELECT id, name, email, created_at FROM students WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM students WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}
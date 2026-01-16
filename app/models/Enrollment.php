<?php

require_once __DIR__ . '/../core/Database.php';

class Enrollment {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function enroll($studentId, $courseId) {
        $sql = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        
        return $stmt->execute();
    }

    public static function getStudentCourses($studentId) {
        $db = Database::getInstance();
        
        $sql = "SELECT c.* FROM courses c 
                INNER JOIN enrollments e ON c.id = e.course_id 
                WHERE e.student_id = :student_id 
                ORDER BY c.title";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function isEnrolled($studentId, $courseId) {
        $sql = "SELECT COUNT(*) as count FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    public function unenroll($studentId, $courseId) {
        $sql = "DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':course_id', $courseId);
        
        return $stmt->execute();
    }

    public static function getCourseStudents($courseId) {
        $db = Database::getInstance();
        
        $sql = "SELECT s.* FROM students s 
                INNER JOIN enrollments e ON s.id = e.student_id 
                WHERE e.course_id = :course_id 
                ORDER BY s.name";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }
}
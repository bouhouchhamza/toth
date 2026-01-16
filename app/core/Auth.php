<?php

class Auth {
    public static function check() {
        return isset($_SESSION['student_id']);
    }

    public static function user() {
        if (self::check()) {
            require_once __DIR__ . '/../models/Student.php';
            return Student::findById($_SESSION['student_id']);
        }
        return null;
    }

    public static function login($studentId) {
        $_SESSION['student_id'] = $studentId;
        $_SESSION['logged_in'] = true;
    }

    public static function logout() {
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        session_destroy();
    }

    public static function requireAuth() {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
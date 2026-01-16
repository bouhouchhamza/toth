<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Auth.php';
require_once __DIR__ . '/../models/Student.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

class StudentController extends Controller {
    
    public function home() {
        $this->view('student/login');
    }

    public function showLogin() {
        $this->view('student/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        if (!Auth::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }

        $email = $this->sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$this->validateRequired([$email, $password])) {
            $error = 'All fields are required';
            $this->view('student/login', ['error' => $error]);
            return;
        }

        $studentModel = new Student();
        $student = $studentModel->authenticate($email, $password);

        if ($student) {
            Auth::login($student['id']);
            $this->redirect('/student/dashboard');
        } else {
            $error = 'Invalid email or password';
            $this->view('student/login', ['error' => $error]);
        }
    }

    public function showRegister() {
        $this->view('student/register');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }

        if (!Auth::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }

        $name = $this->sanitizeInput($_POST['name'] ?? '');
        $email = $this->sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!$this->validateRequired([$name, $email, $password, $confirmPassword])) {
            $error = 'All fields are required';
            $this->view('student/register', ['error' => $error]);
            return;
        }

        if (!$this->validateEmail($email)) {
            $error = 'Invalid email format';
            $this->view('student/register', ['error' => $error]);
            return;
        }

        if (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters';
            $this->view('student/register', ['error' => $error]);
            return;
        }

        if ($password !== $confirmPassword) {
            $error = 'Passwords do not match';
            $this->view('student/register', ['error' => $error]);
            return;
        }

        $studentModel = new Student();
        
        if ($studentModel->findByEmail($email)) {
            $error = 'Email already exists';
            $this->view('student/register', ['error' => $error]);
            return;
        }

        if ($studentModel->register($name, $email, $password)) {
            $this->redirect('/login');
        } else {
            $error = 'Registration failed';
            $this->view('student/register', ['error' => $error]);
        }
    }

    public function dashboard() {
        $student = Auth::user();
        $courses = Enrollment::getStudentCourses($student['id']);
        $allCourses = Course::getAll();
        
        $enrolledCourseIds = array_column($courses, 'id');
        $availableCourses = array_filter($allCourses, function($course) use ($enrolledCourseIds) {
            return !in_array($course['id'], $enrolledCourseIds);
        });

        $this->view('student/dashboard', [
            'student' => $student,
            'courses' => $courses,
            'availableCourses' => $availableCourses
        ]);
    }

    public function course($id) {
        $course = Course::findById($id);
        
        if (!$course) {
            $this->show404();
            return;
        }

        $student = Auth::user();
        $enrollment = new Enrollment();
        $isEnrolled = $enrollment->isEnrolled($student['id'], $id);

        $this->view('student/course', [
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            'student' => $student
        ]);
    }

    public function enroll() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/student/dashboard');
        }

        if (!Auth::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            die('CSRF token validation failed');
        }

        $courseId = $_POST['course_id'] ?? '';
        $student = Auth::user();

        if (!$courseId) {
            $this->redirect('/student/dashboard');
            return;
        }

        $enrollment = new Enrollment();
        
        if (!$enrollment->isEnrolled($student['id'], $courseId)) {
            $enrollment->enroll($student['id'], $courseId);
        }

        $this->redirect("/student/course/{$courseId}");
    }

    public function logout() {
        Auth::logout();
        $this->redirect('/login');
    }

    public function show404() {
        $this->view('student/404');
    }
}

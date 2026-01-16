<?php

session_start();

require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Auth.php';

$router = new Router();

$router->get('/', 'StudentController', 'showLogin');
$router->get('/login', 'StudentController', 'showLogin');
$router->post('/login', 'StudentController', 'login');
$router->get('/register', 'StudentController', 'showRegister');
$router->post('/register', 'StudentController', 'register');

$router->get('/student/dashboard', 'StudentController', 'dashboard', true);
$router->get('/student/course/{id}', 'StudentController', 'course', true);
$router->post('/student/enroll', 'StudentController', 'enroll', true);
$router->get('/logout', 'StudentController', 'logout', true);

$router->dispatch();
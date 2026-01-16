<?php

class Router {
    private $routes = [];
    private $currentRoute = '';

    public function __construct() {
        $this->currentRoute = $_SERVER['REQUEST_URI'];
        $this->currentRoute = strtok($this->currentRoute, '?');
    }

    public function get($path, $controller, $method, $protected = false) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->routes[] = [
                'path' => $path,
                'controller' => $controller,
                'method' => $method,
                'protected' => $protected
            ];
        }
    }

    public function post($path, $controller, $method, $protected = false) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->routes[] = [
                'path' => $path,
                'controller' => $controller,
                'method' => $method,
                'protected' => $protected
            ];
        }
    }

    public function dispatch() {
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route['path'])) {
                if ($route['protected']) {
                    require_once __DIR__ . '/Auth.php';
                    Auth::requireAuth();
                }

                $controllerClass = $route['controller'];
                $controllerMethod = $route['method'];

                require_once __DIR__ . "/../controllers/{$controllerClass}.php";
                $controller = new $controllerClass();
                
                if (method_exists($controller, $controllerMethod)) {
                    $params = $this->getParams($route['path']);
                    call_user_func_array([$controller, $controllerMethod], $params);
                    return;
                }
            }
        }

        $this->show404();
    }

    private function matchRoute($routePath) {
        $routePath = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $routePath = '#^' . $routePath . '$#';
        return preg_match($routePath, $this->currentRoute);
    }

    private function getParams($routePath) {
        $params = [];
        $routeParts = explode('/', trim($routePath, '/'));
        $currentParts = explode('/', trim($this->currentRoute, '/'));

        for ($i = 0; $i < count($routeParts); $i++) {
            if (preg_match('/\{[^}]+\}/', $routeParts[$i])) {
                $params[] = isset($currentParts[$i]) ? $currentParts[$i] : null;
            }
        }

        return $params;
    }

    private function show404() {
        require_once __DIR__ . '/../controllers/StudentController.php';
        $controller = new StudentController();
        $controller->show404();
    }
}
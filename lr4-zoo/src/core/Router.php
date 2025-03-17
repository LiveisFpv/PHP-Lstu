<?php
class Router {
    private $routes = [];

    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri) {
        foreach ($this->routes as $route => $info) {
            if ($route === $uri) {
                $controller = $info['controller'];
                $action = $info['action'];
                $controllerInstance = new $controller();
                $controllerInstance->$action();
                return;
            }
        }
        echo "404 Not Found";
    }
}
?>
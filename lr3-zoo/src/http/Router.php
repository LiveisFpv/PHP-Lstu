<?php

    namespace src\http;
    class Router {
        private array $routes = [];

        // middleware
        public function get(string $route, callable $callback, array $middleware = []): void {
            $this->routes['GET'][$route] = [
                'callback' => $callback,
                'middleware' => $middleware
            ];
        }

        public function post(string $route, callable $callback, array $middleware = []): void {
            $this->routes['POST'][$route] = [
                'callback' => $callback,
                'middleware' => $middleware
            ];
        }

        public function resolve(): void {
            $method = $_SERVER['REQUEST_METHOD'];
            $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

            if (isset($this->routes[$method][$path])) {
                $route = $this->routes[$method][$path];
                // Выполняем middleware
                foreach ($route['middleware'] as $middlewareClass) {
                    (new $middlewareClass())->handle();
                }
                // Выполняем основной обработчик
                call_user_func($route['callback']);
            } else {
                http_response_code(404);
                echo "Not found";
            }
        }
    }
?>
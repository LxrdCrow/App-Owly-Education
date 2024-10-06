<?php

class Router {
    private $routes = [];

    
    public function get($uri, $controllerMethod) {
        $this->addRoute('GET', $uri, $controllerMethod);
    }

    
    public function post($uri, $controllerMethod) {
        $this->addRoute('POST', $uri, $controllerMethod);
    }

    
    public function put($uri, $controllerMethod) {
        $this->addRoute('PUT', $uri, $controllerMethod);
    }

    
    public function delete($uri, $controllerMethod) {
        $this->addRoute('DELETE', $uri, $controllerMethod);
    }

    
    private function addRoute($method, $uri, $controllerMethod) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controllerMethod' => $controllerMethod
        ];
    }

    
    public function dispatch($requestedUri, $requestedMethod) {
        foreach ($this->routes as $route) {
            if ($route['method'] === $requestedMethod && preg_match($this->convertToRegex($route['uri']), $requestedUri, $matches)) {
                $this->callControllerMethod($route['controllerMethod'], $matches);
                return;
            }
        }

        echo json_encode(['message' => 'Route not found']);
    }

    
    private function convertToRegex($uri) {
        return "/^" . str_replace(['{id}'], ['(\d+)'], $uri) . "$/";
    }

    // Chiama il metodo del controller
    private function callControllerMethod($controllerMethod, $params) {
        list($controller, $method) = explode('@', $controllerMethod);

        require_once "../controllers/{$controller}.php";
        $controllerInstance = new $controller();
        call_user_func_array([$controllerInstance, $method], array_slice($params, 1));
    }
}

?>

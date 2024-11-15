<?php

namespace Core;
use Dotenv\Dotenv;

class Router
{
    private $routes = [];
    private $mainRoute;

    public function __construct()
    {
        $this->mainRoute = $this->getBaseRoute();
        Dotenv::createImmutable('./')->load();
    }

    // Método para añadir rutas GET con middlewares opcionales
    public function get($path, $handler, $middlewares = [])
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    // Método para añadir rutas POST con middlewares opcionales
    public function post($path, $handler, $middlewares = [])
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    // Otros métodos para PUT y DELETE
    public function put($path, $handler, $middlewares = [])
    {
        $this->addRoute('PUT', $path, $handler, $middlewares);
    }

    public function delete($path, $handler, $middlewares = [])
    {
        $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute($method, $path, $handler, $middlewares)
    {
        $path = $this->mainRoute . $path;
        $path = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $path);
        $path = str_replace('/', '\/', $path);
        $this->routes[$method][$path] = ['handler' => $handler, 'middlewares' => $middlewares];
    }

    private function getBaseRoute()
    {
        $scriptName = substr($_SERVER['SCRIPT_NAME'],1);
        $partsUri = explode('/', $scriptName);
        if(count($partsUri) > 1) return '/'.$partsUri[0];
        else return '';
    }

    private function handleRequest($requestUri, $requestMethod)
    {
        $requestUri = parse_url($requestUri, PHP_URL_PATH);

        if (isset($this->routes[$requestMethod])) {
            foreach ($this->routes[$requestMethod] as $pattern => $route) {
                if (preg_match('/^' . $pattern . '$/', $requestUri, $matches)) {
                    array_shift($matches);
                    // Ejecutar middlewares
                    $this->runMiddlewares($route['middlewares'], $route['handler'], $matches);
                    return;
                }
            }
        }
        http_response_code($status = 404);
        echo '404 Not Found';
    }

    private function runMiddlewares($middlewares, $handler, $params)
    {
        foreach ($middlewares as $middleware) {
            $middleware($params);
        }
        $this->dispatch($handler, $params);
    }

    private function dispatch($handler, $params)
    {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } else {
            list($controllerName, $method) = explode('@', $handler);
            $controllerFile = 'Controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = new $controllerName();

                if (method_exists($controllerClass, $method)) {
                    call_user_func_array([$controllerClass, $method], $params);
                } else {
                    echo 'Method not found';
                }
            } else {
                echo 'Controller not found';
            }
        }
    }

    public function run(){
        $this->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}

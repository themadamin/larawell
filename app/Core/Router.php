<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected function add($method, $uri, $controller): static
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'middleware' => null
        ];

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function resolve($method, $uri)
    {
        foreach ($this->routes[$method] as $route => $action) {
            // Convert route pattern to regex (e.g., /user/{id} → /user/(\w+))
            $pattern = preg_replace('/\{(\w+)\}/', '(\w+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                // Extract parameters (e.g., id from /user/123)
                $params = array_slice($matches, 1);
                return $this->callAction($action, $params);
            }
        }
        throw new \Exception("Route not found: $uri");
    }

    public function get(string $uri, array $controller): static
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post(string $uri, array $controller): static
    {
        return $this->add('POST', $uri, $controller);
    }

    public function put(string $uri, array $controller): static
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function delete(string $uri, array $controller): static
    {
        return $this->add('DELETE', $uri, $controller);
    }
}
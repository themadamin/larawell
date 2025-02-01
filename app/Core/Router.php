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

    public function resolve($method, $uri)
    {
        foreach($this->routes as $route){
            if ($route['method'] === strtoupper($method) && $route['uri'] === $uri){
                $class = new $route['controller'][0];
                $action = $route['controller'][1];

                return call_user_func([$class, $action]);
            }
        }
        die();
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
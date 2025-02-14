<?php

namespace App\Core;


use Exception;
use ReflectionMethod;

class Router
{
    protected array $routes = [];
    protected function add($method, $uri, $controller): static
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller[0],
            'action' => $controller[1],
            'middleware' => null
        ];

        return $this;
    }

    /**
     * @throws Exception
     */
    public function resolve($method, $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = $route['uri'];
            $regex = preg_replace('/\{(\w+)\}/', '(\w+)', $pattern);
            if (preg_match("#^$regex$#", $uri, $matches) && $route['method'] === strtoupper($method)){
                $params = $matches[1];
                $this->callAction(route: $route, params: $params);
            }
        }
        throw new Exception('No matching routes found', 404);
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

    /**
     * @throws Exception
     */
    protected function callAction(array $route, $params = []) {
        $controller = $route['controller'];
        $action = $route['action'];
        $reflection = new ReflectionMethod($controller, $action);
        $args = [];

        foreach($reflection->getParameters() as $parameter){
            $name = $parameter->getName();
            if (isset($params[$name])) {
                $args[] = $params[$name];
            } else {
                throw new Exception("Argument $name has no default value");
            }
        }

        $reflection->invokeArgs($controller, $args);
    }
}
<?php

class Router
{
private array $routes = [];

    public function AddRoute($method, $url, $controller, $action)
    {
        $this->routes[$method][$url] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

}
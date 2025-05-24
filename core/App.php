<?php

namespace Core;

use ReflectionMethod;

class App
{
    public function dispatch($route, $params = [])
    {
        if (!$route || !is_array($route)) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $controllerName = key($route);
        $method = $route[$controllerName];
        $controllerClass = "App\\Controllers\\{$controllerName}";

        if (!class_exists($controllerClass)) {
            die("Controller '$controllerClass' not found.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            die("Method '$method' not found in $controllerClass.");
        }

        $reflection = new ReflectionMethod($controller, $method);
        $parameters = $reflection->getParameters();
        $dependencies = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if ($type && !$type->isBuiltin()) {
                $className = $type->getName();
                if (class_exists($className)) {
                    $dependencies[] = new $className();
                } else {
                    die("Dependency class '$className' not found.");
                }
            } else {
                $dependencies[] = $params[$name] ?? null;
            }
        }

        echo $reflection->invokeArgs($controller, $dependencies);
    }
}

<?php

require "vendor/autoload.php";

use Core\App;

$basePath = '/mvc_basics'; // adjust if your project is in a subfolder

// Get the request path (strip query params and base path)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim(str_replace($basePath, '', $uri), '/') ?: '/';

$routes = [
    "/"             => ["HomeController" => "index"],
    "/about"        => ["AboutController" => "index"],
    "/user"         => ["UserController" => "index"],
    "/user/list"    => ["UserController" => "list"],
    "/user/@id"     => ["UserController" => "remove"], 
];

$route = null;
$params = [];

foreach ($routes as $routePattern => $handler) {
    $patternRegex = preg_replace('#@(\w+)#', '(?P<\1>[^/]+)', $routePattern);
    $patternRegex = "#^" . rtrim($patternRegex, '/') . "$#";

    if (preg_match($patternRegex, $path, $matches)) {
        $route = $handler;

        // Only keep named captures
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }
        break;
    }
}

$app = new App();
$app->dispatch($route, $params);

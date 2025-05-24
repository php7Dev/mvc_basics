<?php

require "vendor/autoload.php";

use Core\App;

$basePath = '/mvc_basics'; // Change if your app lives in a subfolder

// Get request URI and method
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = rtrim(str_replace($basePath, '', $uri), '/') ?: '/';


// Define routes with HTTP method as first-level key
$routes = [
    'GET' => [
        "/"             => ["HomeController" => "index"],
        "/about"        => ["AboutController" => "index"],
        "/user"         => ["UserController" => "index"],
        "/user/list"    => ["UserController" => "list"],
        "/user/@id"     => ["UserController" => "remove"],
    ],
    'POST' => [
        "/user"         => ["UserController" => "create"],
        "/user/@id"     => ["UserController" => "update"],
    ]
];

// Match route based on method and path
$route = null;
$params = [];

if (isset($routes[$method])) {
    foreach ($routes[$method] as $routePattern => $handler) {
        // Replace @param with named regex capture
        $patternRegex = preg_replace('#@(\w+)#', '(?P<\1>[^/]+)', $routePattern);
        $patternRegex = "#^" . rtrim($patternRegex, '/') . "$#";

        if (preg_match($patternRegex, $path, $matches)) {
            $route = $handler;

            // Extract only named parameters
            foreach ($matches as $key => $value) {
                if (!is_int($key)) {
                    $params[$key] = $value;
                }
            }
            break;
        }
    }
}

$app = new App();
$app->dispatch($route, $params);

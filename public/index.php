<?php

use App\Core\Router;

const BASE_PATH = __DIR__ . '/../';

require BASE_PATH . 'app/Core/functions.php';

require BASE_PATH . 'vendor/autoload.php';

$router = new Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->resolve(method: $method, uri: $uri);
<?php declare(strict_types=1);

use ArticlesApp\Core\Router;
use ArticlesApp\Core\Renderer;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../');
$dotenv->load();

$routes = require_once '../routes.php';

$response = Router::response($routes);
$renderer = new Renderer();

echo $renderer->render($response);
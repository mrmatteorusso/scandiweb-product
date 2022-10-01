<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, PUT, OPTIONS');

header("Access-Control-Allow-Headers: X-Requested-With");

use App\Controllers\ProductController;

use App\Routing\Router;

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();


//"ProductController::class"
$router->add("GET", "products", ProductController::class, "index");
$router->add("POST", "products", ProductController::class, "store");
$router->add("POST", "products/delete", ProductController::class, "massDelete");

header('Content-Type: application/json');
try {
    echo $router->dispatch();
} catch (Exception $exception) {
    $errorCode = $exception->getCode();
    if ($exception instanceof \PDOException) {
        $errorCode = 500;
    }
    $data = [
        "errorMessage" => $exception->getMessage(),
        "errorCode" => $errorCode
    ];
    http_response_code($errorCode);
    echo json_encode(["data" => $data], JSON_PRETTY_PRINT);
}

<?php
$path   = $_GET['path'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

switch ($path) {
    case 'ping':
        require __DIR__ . "/routes/ping.php";
        break;

    case 'products':
        require __DIR__ . "/routes/products.php";
        break;

    case 'test-validate':
        require __DIR__ . "/routes/test-validate.php";
        break;

    default:
        require __DIR__ . "/helpers/response.php";
        json_response([
            "status" => "error",
            "message" => "Route not found"
        ], 404);
}

<?php
function json_response($data, int $statusCode = 200)
{
    http_response_code($statusCode);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit; // langsung stop biar ga lanjut jalan
}

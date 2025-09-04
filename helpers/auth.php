<?php
require __DIR__ . "/../config/security.php";
// require __DIR__ . "/response.php";

function require_api_key()
{
    global $API_KEY;

    // ambil dari header (disarankan) atau query param
    $headers = getallheaders();
    $key = $headers['X-Api-Key'] ?? ($_GET['key'] ?? '');

    if ($key !== $API_KEY) {
        json_response([
            "status" => "error",
            "message" => "Unauthorized - Invalid API key"
        ], 401);
    }
}

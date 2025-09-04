<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/../config/security.php";
require __DIR__ . "/response.php";

function create_jwt($payload)
{
    global $JWT_SECRET;
    $issuedAt   = time();
    $expire     = $issuedAt + 3600; // berlaku 1 jam

    $token = [
        "iat" => $issuedAt,   // issued at
        "exp" => $expire,     // expired
        "data" => $payload    // data user
    ];

    return JWT::encode($token, $JWT_SECRET, 'HS256');
}

function require_jwt()
{
    global $JWT_SECRET;

    $headers = array_change_key_case(getallheaders(), CASE_LOWER);
    $auth = $headers['authorization'] ?? '';

    if (!str_starts_with($auth, 'Bearer ')) {
        json_response(["status" => "error", "message" => "Missing or invalid Authorization header"], 401);
    }

    $jwt = substr($auth, 7); // hapus 'Bearer '

    try {
        $decoded = JWT::decode($jwt, new Key($JWT_SECRET, 'HS256'));
        return (array)$decoded->data; // return data user
    } catch (Exception $e) {
        json_response(["status" => "error", "message" => "Invalid token: " . $e->getMessage()], 401);
    }
}

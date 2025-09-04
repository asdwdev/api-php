<?php
// require __DIR__ . "/../helpers/response.php";
require __DIR__ . "/../helpers/jwt.php";

// input login
$input = json_decode(file_get_contents("php://input"), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// contoh dummy check (harusnya cek ke database)
if ($username === "admin" && $password === "123456") {
    $token = create_jwt(["username" => $username]);
    json_response([
        "status" => "success",
        "token" => $token
    ]);
} else {
    json_response(["status" => "error", "message" => "Invalid credentials"], 401);
}

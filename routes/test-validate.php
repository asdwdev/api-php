<?php
require __DIR__ . "/../helpers/response.php";
require __DIR__ . "/../helpers/validator.php";

$input = json_decode(file_get_contents("php://input"), true);

$errors = validate($input, [
    'title' => 'required|max:255',
    'body'  => 'required',
    'price' => 'required|numeric'
]);

if (!empty($errors)) {
    json_response(["status" => "error", "errors" => $errors], 400);
}

// kalau lolos validasi
json_response(["status" => "success", "message" => "Data valid!"]);

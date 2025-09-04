<?php
header("Content-Type: application/json");

// contoh parameter dari URL
$age = $_GET["age"] ?? null;

if ($age === null) {
    // kalau parameter gak ada -> bad request
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "parameter 'age' is required"
    ]);
    exit;
}

if (!is_numeric($age)) {
    // kalau bukan angka -> bad request
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "parameter 'age' must be a number"
    ]);
    exit;
}

$age = (int) $age;

if ($age < 18) {
    // kalau kurang dari 18 -> forbidden
    http_response_code(403);
    echo json_encode([
        "status" => "error",
        "message" => "you must be 18+ to access this resource"
    ]);
    exit;
}

// kalau semua valid -> success
http_response_code(200);
echo json_encode([
    "status" => "success",
    "message" => "welcome! your age is $age"
]);

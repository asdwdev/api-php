<?php
require "helpers/response.php";

// ambil param age
$age = $_GET["age"] ?? null;

if ($age === null) {
    json_response(
        ["status" => "error", "message" => "parameter 'age' is required"],
        400
    );
}

if (!is_numeric($age)) {
    json_response(
        ["status" => "error", "message" => "parameter 'age' must be a number"],
        400
    );
}

$age = (int)$age;

if ($age < 18) {
    json_response(
        ["status" => "error", "message" => "you must be 18+ to access this resource"],
        403
    );
}

json_response(
    ["status" => "success", "message" => "welcome! your age is $age"],
    200
);

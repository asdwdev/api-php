<?php
require __DIR__ . "/../helpers/response.php";
require __DIR__ . "/../config.php";

$result = $conn->query("SELECT * FROM products");
$data = $result->fetch_all(MYSQLI_ASSOC);

json_response([
    "status" => "success",
    "data" => $data
]);

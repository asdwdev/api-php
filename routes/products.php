<?php
require __DIR__ . "/../helpers/validate.php";
require __DIR__ . "/../helpers/auth.php";
require __DIR__ . "/../helpers/jwt.php";
require __DIR__ . "/../config/database.php";

// require_api_key();
$user = require_jwt();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // jika ada id → ambil detail
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $res = $conn->query("SELECT * FROM products WHERE id=$id");
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                json_response(["status" => "success", "data" => $row]);
            } else {
                json_response(["status" => "error", "message" => "Product not found"], 404);
            }
        } else {
            // list semua produk
            $res = $conn->query("SELECT * FROM products");
            $rows = $res->fetch_all(MYSQLI_ASSOC);
            json_response(["status" => "success", "data" => $rows]);
        }
        break;

    case "POST":
        $input = json_decode(file_get_contents("php://input"), true);

        $errors = validate_product_input($input);
        if (!empty($errors)) {
            json_response([
                "status" => "error",
                "errors" => $errors
            ], 400);
        }

        $name  = $conn->real_escape_string($input['name']);
        $price = intval($input['price']);
        $conn->query("INSERT INTO products (name, price) VALUES ('$name', $price)");
        $id = $conn->insert_id;
        json_response(["status" => "success", "message" => "Product created", "id" => $id], 201);
        break;

    case 'PUT':
        $id = intval($_GET['id'] ?? 0);
        $check = $conn->query("SELECT * FROM products WHERE id=$id");
        if ($check->num_rows === 0) {
            json_response(["status" => "error", "message" => "Product not found"], 404);
        }

        $input = json_decode(file_get_contents("php://input"), true);
        $errors = validate_product_input($input);
        if (!empty($errors)) {
            json_response([
                "status" => "error",
                "errors" => $errors
            ], 400);
        }

        $name  = $conn->real_escape_string($input['name']);
        $price = intval($input['price']);
        $conn->query("UPDATE products SET name='$name', price=$price WHERE id=$id");
        json_response(["status" => "success", "message" => "Product updated"]);
        break;

    case 'DELETE':
        $id = intval($_GET['id'] ?? 0);
        $check = $conn->query("SELECT * FROM products WHERE id=$id");
        if ($check->num_rows === 0) {
            json_response(["status" => "error", "message" => "Product not found"], 404);
        }
        $conn->query("DELETE FROM products WHERE id=$id");
        json_response(["status" => "success", "message" => "Product deleted"]);
        break;

    default:
        json_response(["status" => "error", "message" => "Method not allowed"], 405);
}

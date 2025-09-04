<?php
function validate_product_input($input)
{
    $errors = [];

    // cek name
    if (!isset($input['name']) || trim($input['name']) === '') {
        $errors[] = "Name is required";
    } elseif (strlen($input['name']) < 3) {
        $errors[] = "Name must be at least 3 characters";
    }

    // cek price
    if (!isset($input['price'])) {
        $errors[] = "Price is required";
    } elseif (!is_numeric($input['price'])) {
        $errors[] = "Price must be a number";
    } elseif ($input['price'] <= 0) {
        $errors[] = "Price must be greater than 0";
    }

    return $errors;
}

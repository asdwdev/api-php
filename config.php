<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "belajar_api";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("db connection failed: " . $conn->connect_error);
}

// api key
$API_KEY = "123456SECRET";

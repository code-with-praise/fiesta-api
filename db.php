<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Switch between local and live automatically
$is_local = ($_SERVER['HTTP_HOST'] === 'localhost');

if ($is_local) {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "hotel_system"; // your local database name in phpMyAdmin
} else {
    $host = "sql111.infinityfree.com";
    $user = "if0_41877118";
    $pass = "Fiesta@123456789"; // ← fill this in
    $db   = "if0_41877118_hotel_system"; // ← fill this in
}

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed: " . mysqli_connect_error()]);
    exit();
}
?>
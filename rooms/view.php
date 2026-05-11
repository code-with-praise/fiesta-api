<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["error" => "Room ID is required"]);
    exit();
}

$sql = "SELECT * FROM rooms WHERE id = $id";
$result = mysqli_query($conn, $sql);
$room = mysqli_fetch_assoc($result);

if ($room) {
    echo json_encode($room);
} else {
    echo json_encode(["error" => "Room not found"]);
}
?>
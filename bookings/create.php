<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include '../db.php';

$data = json_decode(file_get_contents("php://input"), true);

$room_id = $data['room_id'] ?? '';
$guest_name = $data['guest_name'] ?? '';
$guest_email = $data['guest_email'] ?? '';
$phone = $data['phone'] ?? '';
$special_requests = $data['special_requests'] ?? '';
$check_in = $data['check_in'] ?? '';
$check_out = $data['check_out'] ?? '';
$guests = $data['guests'] ?? 1;

if (!$room_id || !$guest_name || !$guest_email || !$check_in || !$check_out) {
    echo json_encode(["error" => "All fields are required"]);
    exit();
}

$stmt = mysqli_prepare($conn, "INSERT INTO bookings (room_id, guest_name, guest_email, phone, special_requests, check_in, check_out, guests, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
mysqli_stmt_bind_param($stmt, "issssssi", $room_id, $guest_name, $guest_email, $phone, $special_requests, $check_in, $check_out, $guests);

if (mysqli_stmt_execute($stmt)) {
    mysqli_query($conn, "UPDATE rooms SET status='unavailable' WHERE id=$room_id");
    $booking_id = mysqli_insert_id($conn);
    echo json_encode(["message" => "Booking created successfully", "booking_id" => $booking_id]);
} else {
    echo json_encode(["error" => "Booking failed: " . mysqli_error($conn)]);
}
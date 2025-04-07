<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit();
}

require_once("db_connection.php");

$user = $_SESSION['username'];
$room = isset($_POST['room']) ? trim($_POST['room']) : '';

if (empty($room)) {
    echo json_encode(["success" => false, "message" => "Room name is required"]);
    exit();
}

try {
    $stmt = $conn->prepare("UPDATE users SET roomid = ? WHERE username = ?");
    if (!$stmt) {
        throw new Exception($conn->error);
    }
    
    $stmt->bind_param("ss", $room, $user);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "room" => $room]);
    } else {
        throw new Exception("Failed to update room");
    }
    
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: about.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trash-pickup-game";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_SESSION['username'];

// $stmt = $conn->prepare("SELECT score FROM users WHERE username = ?");
// $stmt->bind_param("s", $user);
// $stmt->execute();
// $stmt->bind_result($score);
// $stmt->fetch();
// $stmt->close();

// $stmt = $conn->prepare("SELECT roomid FROM users WHERE username = ?");
// $stmt->bind_param("s", $user);
// $stmt->execute();
// $stmt->bind_result($room);
// $stmt->fetch();
// $stmt->close();

// $conn->close();
?>
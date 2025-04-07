<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php
// session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trash-pickup-game";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the roomid of the logged-in user
$user = $_SESSION['username'];
$stmt = $conn->prepare("SELECT roomid FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($roomid);
$stmt->fetch();
$stmt->close();

// Get leaderboard for that room
$leaderboard = [];
$stmt = $conn->prepare("SELECT username, score FROM users WHERE roomid = ? ORDER BY score DESC");
$stmt->bind_param("i", $roomid);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $leaderboard[] = $row;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trash Collector</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
        <a href="" id="empty-nav-box"></a>
        <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
        <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
        <a href="join-room.php" id="join-room-btn"><button class="nav-btn box-btn home-btm">Join Room</button></a>
        <a href="logout.php" id="logout-btn"><button class="nav-btn box-btn home-btm">Logout</button></a>
    </nav>
    <div class="main">
        <div class="main-container">
            <?php foreach ($leaderboard as $index => $entry): ?>
                <div class="leaderboard-card
                    <?php echo $index === 0 ? 'winner-card' : ($index === 1 ? 'runnerup-card' : ''); ?>">
                    <p class="card-key"><?php echo htmlspecialchars($entry['username']); ?></p>
                    <p class="card-value"><?php echo $entry['score']; ?> points</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

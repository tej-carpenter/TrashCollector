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

$stmt = $conn->prepare("SELECT score FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($score);
$stmt->fetch();
$stmt->close();

$stmt = $conn->prepare("SELECT roomid FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->bind_result($room);
$stmt->fetch();
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
        <div class="main-container" style="display:flex;justify-content:space-between;flex-wrap:wrap;">
            <!-- <a href="index.php"><button class="btn square-card" id="profile-btn">Profile</button></a>
            <a href="upload.php"><button class="btn square-card" id="register-btn">Submit Trash</button></a>
            <a href="leaderboard.php"><button class="btn square-card" id="login-btn">Leaderboard</button></a>
            <a href="join-room.php"><button class="btn square-card" id="join-room-btn">Join Room</button></a> -->
            <a href="index.php">
                <div class="square-card">
                    <div class="upper-square-card">
                    <?php
                            echo $user
                        ?>
                    </div>
                    <div class="lower-square-card">username</div>
                </div>
            </a>
            <a href="leaderboard.php">
                <div class="square-card">
                    <div class="upper-square-card">
                        <?php
                            echo $score
                        ?>
                    </div>
                    <div class="lower-square-card">score</div>
                </div>
            </a>
            <a href="leaderboard.php">
                <div class="square-card">
                    <div class="upper-square-card">
                        <?php
                            echo $room
                        ?>
                    </div>
                    <div class="lower-square-card">room</div>
                </div>
            </a>
        </div>
    </div>
</body>
</html>

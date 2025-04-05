<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: about.php");
    exit();
}
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
        <a href="logout.php" id="logout-btn"><button class="nav-btn box-btn home-btm">Logout</button></a>
    </nav>

    <div class="main">
        <div class="main-container">
            <a href="profile.php"><button class="btn main-page-btn" id="profile-btn">Profile</button></a>
            <a href="upload.php"><button class="btn main-page-btn" id="register-btn">Submit Trash</button></a>
            <a href="leaderboard.php"><button class="btn main-page-btn" id="login-btn">Leaderboard</button></a>
            <a href="join-room.php"><button class="btn main-page-btn" id="join-room-btn">Join Room</button></a>
        </div>
    </div>
</body>
</html>

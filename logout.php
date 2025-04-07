<?php
session_start();
session_unset();
session_destroy();
header("Refresh: 1; url=login.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trash Collector - Logout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
        <a href="" id="empty-nav-box"></a>
        <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
        <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
        <a href="join-room.php" id="join-room-btn"><button class="nav-btn box-btn home-btm">Join Room</button></a>
        <a href="login.php" id="login-btn"><button class="nav-btn box-btn home-btm">Login</button></a>
    </nav>
    <div class="main">
        <div class="main-container">
            <div class="leaderboard-card">
                <p class="card-key">You have been logged out.</p>
                <p class="card-value">Redirecting to login...</p>
            </div>
        </div>
    </div>
</body>
</html>

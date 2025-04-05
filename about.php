<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>About - Trash Collector</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="profile.php" id="profile-btn"><button class="nav-btn box-btn">Profile</button></a>
            <a href="" id="empty-nav-box"></a>
            <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
            <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
            <a href="logout.php" id="logout-btn"><button class="nav-btn box-btn home-btm">Logout</button></a>
        <?php else: ?>
            <a href="index.php" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
            <a href="" id="empty-nav-box"></a>
            <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
            <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
            <a href="login.php" id="login-btn"><button class="nav-btn box-btn home-btm">Login</button></a>
        <?php endif; ?>
    </nav>

    <div class="main">
        <div class="main-container">
                <div class="about">
                    <h2>About Trash Collector</h2>
                    <p>
                        Trash Collector is a multiplayer web-based game designed to encourage environmental responsibility through friendly competition. Players can join rooms, report trash they’ve picked up, and earn points for their team or group.
                    </p>
                    <p>
                        This game aims to gamify real-world impact by rewarding users for their eco-friendly actions. Leaderboards display top performers by room, making cleanup both fun and motivating.
                    </p>
                    <p>
                        Join the movement, clean the environment, and climb the leaderboard!
                    </p>
                </div>
        </div>
    </div>
</body>
</html>

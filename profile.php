<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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
            <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">leaderboard</button></a>
            <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">upload</button></a>
            <a href="login.php" id="login-btn"><button class="nav-btn box-btn home-btm">login</button></a>

        </nav>
        <div class="main">
            <div class="main-container">
                
            </div>
        </div>
    </body>
</html>
<?php
// End PHP tag if needed for further PHP logic
?>
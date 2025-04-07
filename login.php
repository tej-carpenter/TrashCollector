<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trash-pickup-game";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($pass, $hashed_password)) {
            $_SESSION['username'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $loginError = "❌ Invalid password.";
        }
    } else {
        $loginError = "❌ No user found with this username.";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Trash Collector - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="index.php" id="profile-btn"><button class="nav-btn box-btn">Profile</button></a>
            <a href="" id="empty-nav-box"></a>
            <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
            <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
        <a href="join-room.php" id="join-room-btn"><button class="nav-btn box-btn home-btm">Join Room</button></a>
        <a href="logout.php" id="logout-btn"><button class="nav-btn box-btn home-btm">Logout</button></a>
        <?php else: ?>
            <a href="index.php" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
            <a href="" id="empty-nav-box"></a>
            <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
            <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
        <a href="join-room.php" id="join-room-btn"><button class="nav-btn box-btn home-btm">Join Room</button></a>
        <a href="register.php" id="register-btn"><button class="nav-btn box-btn home-btm">Register</button></a>
        <?php endif; ?>
    </nav>

    <div class="main">
        <div class="main-container">
            <?php if (!empty($loginError)) : ?>
                <div class="message error"><?php echo $loginError; ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <fieldset>
                    <legend>Username</legend>
                    <input type="text" name="username" id="username" required>
                </fieldset>
                <fieldset>
                    <legend>Password</legend>
                    <input type="password" name="password" id="password" required>
                </fieldset>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>

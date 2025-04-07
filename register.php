<?php
$successMessage = "";
$errorMessage = "";

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trash-pickup-game";
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $email, $pass);

    if ($stmt->execute()) {
        $successMessage = "✅ Registration successful! You can now log in.";
    } else {
        $errorMessage = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
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
        <a href="" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
        <a href="" id="empty-nav-box"></a>
        <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
        <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
        <a href="login.php" id="login-btn"><button class="nav-btn box-btn home-btm">Login</button></a>
    </nav>
    <div class="main">
        <div class="main-container">
            <form action="register.php" method="post">
                <fieldset>
                    <legend>Username</legend>
                    <input type="text" name="username" id="username" required>
                </fieldset>
                <fieldset>
                    <legend>Email</legend>
                    <input type="email" name="email" id="email" required>
                </fieldset>
                <fieldset>
                    <legend>Password</legend>
                    <input type="password" name="password" id="password" required>
                </fieldset>
                <button type="submit" class="btn">Register</button>
                <?php if (!empty($successMessage)) : ?>
                    <div class="message success"><?php echo $successMessage; ?></div>
                <?php endif; ?>

                <?php if (!empty($errorMessage)) : ?>
                    <div class="message error"><?php echo $errorMessage; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>
</html>
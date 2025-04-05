<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
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

$updatedScore = null;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trashType = $_POST['trash-type'];
    $weight = intval($_POST['weight']);
    $user = $_SESSION['username'];

    // Define points per gram based on type
    $scorePerGram = [
        "solid" => 1,
        "liquid" => 2,
        "organic" => 3,
        "hazardous" => 5,
        "recyclable" => 4
    ];

    if (isset($scorePerGram[$trashType]) && $weight > 0) {
        $score = $scorePerGram[$trashType] * $weight;
        
        // Update user score
        $stmt = $conn->prepare("UPDATE users SET score = score + ? WHERE username = ?");
        $stmt->bind_param("is", $score, $user);
        $stmt->execute();
        $stmt->close();

        // Get updated score
        $stmt = $conn->prepare("SELECT score FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->bind_result($updatedScore);
        $stmt->fetch();
        $stmt->close();

        $message = "✅ Trash submitted successfully!";
    } else {
        $message = "❌ Please select a valid trash type and weight.";
    }
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
    <a href="profile.php" id="home-btn"><button class="nav-btn box-btn">Profile</button></a>
    <a href="" id="empty-nav-box"></a>
    <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">Leaderboard</button></a>
    <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">Upload</button></a>
    <a href="logout.php" id="logout-btn"><button class="nav-btn box-btn home-btm">Logout</button></a>
</nav>

<div class="main">
    <div class="main-container">
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!is_null($updatedScore)): ?>
            <div class="leaderboard-card">
                <p class="team-name">score</p>
                <p class="team-score"><?= $updatedScore ?> pts</p>
            </div>
        <?php endif; ?>

        <div class="upload-form">
            <form action="upload.php" method="post">
                <fieldset>
                    <legend>Trash Type</legend>
                    <select name="trash-type" id="trash-type" required>
                        <option value="select">Select</option>
                        <option value="solid">Solid</option>
                        <option value="liquid">Liquid</option>
                        <option value="organic">Organic</option>
                        <option value="hazardous">Hazardous</option>
                        <option value="recyclable">Recyclable</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legend>Approximate Weight (in grams)</legend>
                    <input type="number" name="weight" id="weight" required>
                </fieldset>
                    <fieldset>
                        <legend>Upload file</legend>
                        <input type="file" name="photo" id="photo">
                    </fieldset>
                <button class="btn" type="reset">Cancel</button>
                <button class="btn" id="upload-submit" type="submit">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>

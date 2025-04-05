<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Join Room</title>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
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
            <h2>Welcome, <?php echo htmlspecialchars($username); ?>! Join a room:</h2>
            <form id="joinForm">
                <input type="text" id="room" placeholder="Enter Room ID" required>
                <button type="submit">Join</button>
            </form>
        </div>
    </div>

    <script>
        const socket = io("http://localhost:3000");

        const username = "<?php echo $username; ?>";
        document.getElementById("joinForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const room = document.getElementById("room").value;
            socket.emit("joinRoom", { room, username });
            alert(`Joined room: ${room}`);
        });
    </script>
</body>
</html>

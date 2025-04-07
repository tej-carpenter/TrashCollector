<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Make username available for JavaScript
$user = $_SESSION['username'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include("db_connection.php"); // adjust this to your db file
    $room = $_SESSION['roomid'];
    
    $stmt = $conn->prepare("UPDATE users SET roomid = ? WHERE username = ?");
    $stmt->bind_param("ss", $room, $user);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "room" => $room]);
    } else {
        echo json_encode(["success" => false, "message" => "DB error"]);
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trash Collector</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
</head>
<body>
    <nav>
        <a href="index.php" id="home-btn"><button class="nav-btn box-btn">Home</button></a>
        <a href="" id="empty-nav-box"></a>
        <a href="leaderboard.php" id="leaderboard-btn"><button class="nav-btn box-btn home-btm">leaderboard</button></a>
        <a href="upload.php" id="upload-btn"><button class="nav-btn box-btn home-btm">upload</button></a>
        <a href="join-room.php" id="join-room-btn"><button class="nav-btn box-btn home-btm">Join Room</button></a>
        <a href="logout.php" id="login-btn"><button class="nav-btn box-btn home-btm">logout</button></a>
    </nav>

    <div class="main">
        <div class="main-container">
            <div class="upload-form">
                <form id="joinForm">
                    <fieldset>
                        <legend>Join Room</legend>
                        <input type="text" name="room" id="room" placeholder="Enter room name" required>
                    </fieldset>
                    <button class="btn" type="reset">cancel</button>
                    <button class="btn" type="submit">join</button>
                </form>
            </div>
            <div class="message"></div>
        </div>
    </div>

    <script>
    const socket = io("http://localhost:3000");
    const user = "<?php echo htmlspecialchars($user, ENT_QUOTES); ?>";

    document.getElementById("joinForm").addEventListener("submit", function (e) {
        e.preventDefault();
        const room = document.getElementById("room").value;
        const msgDiv = document.querySelector(".message");

        fetch("join-room-backend.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `room=${encodeURIComponent(room)}`
        })
        .then(async res => {
            const text = await res.text();
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Server response:', text);
                throw new Error('Invalid JSON response from server');
            }
        })
        .then(data => {
            if (data.success) {
                socket.emit("joinRoom", { room, user });
                msgDiv.innerHTML = `<p>Successfully joined room <b>${room}</b></p>`;
                setTimeout(() => {
                    window.location.href = 'game.php';
                }, 2000);
            } else {
                msgDiv.innerHTML = `<p class="error">${data.message}</p>`;
            }
        })
        .catch(error => {
            console.error(error);
            msgDiv.innerHTML = `<p class="error">Connection error: ${error.message}</p>`;
        });
    });
    </script>
</body>
</html>

// Register user
function register() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    if (username === "" || password === "") {
        document.getElementById("message").innerText = "All fields are required!";
        return;
    }

    fetch("http://localhost:5500/login", {  // ✅ Updated URL
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("message").innerText = data.message;
    })
    .catch(error => console.error("Error:", error));
}

// Login user
function login() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    fetch("http://localhost:5500/login", {  // ✅ Updated URL
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("message").innerText = data.message;
        if (data.message === "Login successful!") {
            window.location.href = "/frontend"; 
        }
    })
    .catch(error => console.error("Error:", error));
}

// Register user
function register() {
    let username = document.getElementById("reg-username").value;
    let password = document.getElementById("reg-password").value;

    if (username === "" || password === "") {
        document.getElementById("reg-message").innerText = "All fields are required!";
        return;
    }

    if (localStorage.getItem(username)) {
        document.getElementById("reg-message").innerText = "Username already exists!";
    } else {
        localStorage.setItem(username, password);
        document.getElementById("reg-message").innerText = "Registration successful! You can now log in.";
    }
}

// Login user
function login() {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    if (localStorage.getItem(username) === password) {
        document.getElementById("message").innerText = "Login successful!";
        window.location.href = "/frontend"; // Redirect to game page
    } else {
        document.getElementById("message").innerText = "Invalid username or password!";
    }
}

// Handle both register and login actions
function handleAuth(action) {
    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;

    if (username === "" || password === "") {
        document.getElementById("message").innerText = "All fields are required!";
        return;
    }

    const endpoint = action === "register" ? "/register" : "/login";

    fetch(`http://127.0.0.1:5500${endpoint}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => {
                const errorMessage = text || "An error occurred.";
                throw new Error(errorMessage);
            });
        }
        return response.text().then(text => {
            try {
                return text ? JSON.parse(text) : {}; // Safely parse JSON
            } catch (e) {
                throw new Error("Invalid JSON response from server.");
            }
        });
    })
    .then(data => {
        document.getElementById("message").innerText = data.message || 
            (action === "register" ? "Registration successful!" : "Login successful!");

        if (action === "login" && data.message === "Login successful!") {
            localStorage.setItem("isLoggedIn", "true"); // Save login status
            localStorage.setItem("username", username); // Save username
            window.location.href = "/frontend"; // Redirect to the main page
        }
    })
    .catch(error => {
        console.error("Error:", error);
        document.getElementById("message").innerText = error.message || "An error occurred.";
    });
}

// Check login status and update navbar
function updateNavbar() {
    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    const loginBtn = document.getElementById("login-btn");
    const profileBtn = document.getElementById("profile-btn");

    if (isLoggedIn) {
        if (loginBtn) loginBtn.style.display = "none";
        if (profileBtn) profileBtn.style.display = "inline-block";
    } else {
        if (loginBtn) loginBtn.style.display = "inline-block";
        if (profileBtn) profileBtn.style.display = "none";
    }
}

// Call updateNavbar on page load
document.addEventListener("DOMContentLoaded", updateNavbar);

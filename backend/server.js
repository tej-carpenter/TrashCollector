const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const users = {
    "user1": "password123",
    "user2": "securepass"
};

// Register User
app.post('/register', (req, res) => {
    const { username, password } = req.body;
    if (!username || !password) {
        return res.status(400).json({ message: "All fields are required!" });
    }
    if (users[username]) {
        return res.status(400).json({ message: "Username already exists!" });
    }
    users[username] = password;
    return res.json({ message: "Registration successful!" });
});

// Login User
app.post('/login', (req, res) => {
    const { username, password } = req.body;
    if (users[username] === password) {
        return res.json({ message: "Login successful!" });
    }
    return res.status(401).json({ message: "Invalid username or password!" });
});

// Start the server
const PORT = 5500;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));

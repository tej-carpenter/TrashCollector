const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const mongoose = require('mongoose');

const app = express();
app.use(cors());
app.use(bodyParser.json());

// Connect to MongoDB
mongoose.connect('mongodb://127.0.0.1:27017/trashCollector', { useNewUrlParser: true, useUnifiedTopology: true })
    .then(() => console.log('Connected to MongoDB'))
    .catch(err => console.error('Could not connect to MongoDB:', err));

// Define User Schema and Model
const userSchema = new mongoose.Schema({
    username: { type: String, required: true, unique: true },
    password: { type: String, required: true },
    score: { type: Number, default: 0 } // Added score field with default value
});
const User = mongoose.model('User', userSchema);

// Register User
app.post('/register', async (req, res) => {
    const { username, password } = req.body;
    if (!username || !password) {
        return res.status(400).json({ message: "All fields are required!" });
    }
    try {
        const existingUser = await User.findOne({ username });
        if (existingUser) {
            return res.status(400).json({ message: "User already exists! Try selecting a different username." });
        }
        const newUser = new User({ username, password, score: 0 }); // Initialize score to 0
        await newUser.save();
        return res.json({ message: "Registration successful!" });
    } catch (err) {
        console.error(err);
        return res.status(500).json({ message: "Internal server error." });
    }
});

// Login User
app.post('/login', async (req, res) => {
    const { username, password } = req.body;
    try {
        const user = await User.findOne({ username, password });
        if (user) {
            return res.json({ message: "Login successful!" }); // Ensure a response is always sent
        }
        return res.status(401).json({ message: "Invalid username or password!" });
    } catch (err) {
        console.error(err);
        return res.status(500).json({ message: "Internal server error." }); // Handle errors properly
    }
});

// Get User Profile (including score)
app.get('/profile/:username', async (req, res) => {
    const { username } = req.params;
    try {
        const user = await User.findOne({ username });
        if (user) {
            return res.json({ username: user.username, score: user.score });
        }
        return res.status(404).json({ message: "User not found!" });
    } catch (err) {
        console.error(err);
        return res.status(500).json({ message: "Internal server error." });
    }
});

// Update User Score
app.put('/profile/:username/score', async (req, res) => {
    const { username } = req.params;
    const { score } = req.body;
    try {
        const user = await User.findOneAndUpdate(
            { username },
            { score },
            { new: true }
        );
        if (user) {
            return res.json({ message: "Score updated successfully!", score: user.score });
        }
        return res.status(404).json({ message: "User not found!" });
    } catch (err) {
        console.error(err);
        return res.status(500).json({ message: "Internal server error." });
    }
});

// Start the server
const PORT = 5500;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));

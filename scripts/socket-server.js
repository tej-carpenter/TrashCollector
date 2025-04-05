const express = require('express');
const http = require('http');
const cors = require('cors');
const { Server } = require('socket.io');

const app = express();
app.use(cors());

const server = http.createServer(app);

const io = new Server(server, {
  cors: {
    origin: "*", // Allow all origins during dev
    methods: ["GET", "POST"]
  }
});

// Store room scores (could sync with MySQL later)
const roomScores = {};

io.on('connection', (socket) => {
  console.log(`🔌 New connection: ${socket.id}`);

  socket.on('joinRoom', ({ room, username }) => {
    socket.join(room);
    console.log(`${username} joined room ${room}`);
    io.to(room).emit('userJoined', `${username} joined the room`);
  });

  socket.on('scoreUpdate', ({ room, username, score }) => {
    if (!roomScores[room]) roomScores[room] = {};
    roomScores[room][username] = (roomScores[room][username] || 0) + score;

    io.to(room).emit('leaderboardUpdate', roomScores[room]);
  });

  socket.on('disconnect', () => {
    console.log(`❌ Disconnected: ${socket.id}`);
  });
});

server.listen(3000, () => {
  console.log('✅ Socket.IO server running on port 3000');
});

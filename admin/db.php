<?php
// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "tour_travals";

// 1. Connection Create karein
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 2. Connection Check karein
if (!$conn) {
    // Agar connection fail ho jaye toh error dikhaye
    die("❌ Connection failed: " . mysqli_connect_error());
}

// 3. Character set set karein (Taki Hindi ya Emojis sahi se save hon)
mysqli_set_charset($conn, "utf8mb4");


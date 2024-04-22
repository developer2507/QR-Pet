<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "qrpet";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($conn == null) {
    die("Could not connect to database.");
}
?>
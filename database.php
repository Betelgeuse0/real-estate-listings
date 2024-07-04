<?php
$servername = "localhost";
$username = "kenton"; // default XAMPP username
$password = "123456"; // default XAMPP password
$dbname = "realestate";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

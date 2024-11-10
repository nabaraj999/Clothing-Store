<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cs";

// Create the connection
$conn = mysqli_connect($servername, $username, $password, $dbname, 3307);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

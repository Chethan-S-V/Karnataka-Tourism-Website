<?php
$host = 'localhost';
$db   = 'karnatism';
$user = 'root'; // change if your username is different
$pass = '';     // change if your DB has a password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

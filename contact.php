<?php
// DB configuration
$servername = "localhost";
$username = "root";
$password = ""; // Default is empty for XAMPP
$dbname = "karnatism"; // Change this to your actual DB name

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check for DB connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Check for empty fields
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill all fields.";
        exit;
    }

    // Prepare SQL to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            echo "success";
        } else {
            echo "Error saving your message.";
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
}

$conn->close();
?>

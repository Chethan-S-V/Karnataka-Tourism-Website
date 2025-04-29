<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karnatism";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

// Delete booking
$sql = "DELETE FROM bookings WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Delete ticket image
    $ticket_path = "assets/images/Ticket4$id.png";
    if (file_exists($ticket_path)) {
        unlink($ticket_path);
    }
    echo "Booking Cancelled Successfully.";
} else {
    echo "Error deleting booking.";
}

$conn->close();
?>

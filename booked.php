<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get booking ID from URL

    // Fetch booking details from the database
    $conn = new mysqli('localhost', 'root', '', 'karnatism');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM bookings WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h1>Your Booking</h1>";
        echo "<p>Booking ID: " . $row['id'] . "</p>";
        echo "<p>Name: " . $row['name'] . "</p>";
        echo "<p>Tour: " . $row['tour'] . "</p>";
        echo "<p>Booking Date: " . $row['validation_date'] . "</p>";
        echo "<p>Seat Type: " . $row['seat_type'] . "</p>";
        echo "<p>Valid Till: " . $row['validation_time'] . "</p>";

        // Show the generated ticket image
        $ticket_path = "assets/images/Ticket4_$id.png";
        echo "<img src='$ticket_path' alt='Booking Ticket'>";
    } else {
        echo "Booking not found.";
    }

    $conn->close();
}
?>

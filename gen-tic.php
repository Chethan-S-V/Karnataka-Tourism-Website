<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karnatism";

// Create connection to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Receive and sanitize data from the form
$name = htmlspecialchars($_POST['name']);  // Sanitize user input to avoid XSS
$tour = htmlspecialchars($_POST['tour']);
$date = $_POST['validation_date'];
$seat_type = htmlspecialchars($_POST['seat_type']);
$validation_time = $_POST['validation_time'];

// Insert the received booking data into the database
$sql = "INSERT INTO bookings (name, tour, validation_date, seat_type, validation_time) 
        VALUES ('$name', '$tour', '$date', '$seat_type', '$validation_time')";

if ($conn->query($sql) === TRUE) {
    // Get the last inserted ID to link the ticket
    $last_id = $conn->insert_id;

    // Load an existing image template
    $image = imagecreatefrompng("assets/images/Ticket4.png");  // Image template for ticket
    $text_color = imagecolorallocate($image, 0, 0, 0);  // Color for the text (black)
    $font = 'arial.ttf';  // Font file (make sure it's available)

    // Adding the title at the top of the ticket
    imagettftext($image, 30, 0, 50, 50, $text_color, $font, "Booking Confirmation");

    // Add booking details to the image
    imagettftext($image, 20, 0, 50, 100, $text_color, $font, "Booking ID: $last_id");
    imagettftext($image, 20, 0, 50, 150, $text_color, $font, "Name: $name");
    imagettftext($image, 20, 0, 50, 200, $text_color, $font, "Tour: $tour");
    imagettftext($image, 20, 0, 50, 250, $text_color, $font, "Date: $date");
    imagettftext($image, 20, 0, 50, 300, $text_color, $font, "Seat Type: $seat_type");
    imagettftext($image, 20, 0, 50, 350, $text_color, $font, "Valid Till: $validation_time");

    // Save the image with a unique name (using the last inserted ID)
    $ticket_path = "assets/images/Ticket4_$last_id.png";
    imagepng($image, $ticket_path);  // Save the image as PNG
    imagedestroy($image);  // Free memory used by the image

    // Redirect to a page showing the ticket (optional)
    header("Location: booked.php?id=$last_id");

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

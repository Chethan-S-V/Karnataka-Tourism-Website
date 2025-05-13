<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "karnatism";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$name = htmlspecialchars($_POST['name']);
$tour = htmlspecialchars($_POST['tour']);
$date = $_POST['validation_date'];
$seat_type = htmlspecialchars($_POST['seat_type']);
$validation_time = $_POST['validation_time'];

// Check seat availability
$checkSeats = "SELECT COUNT(*) AS total FROM bannerghatta WHERE tour = '$tour'";
$result = $conn->query($checkSeats);
$row = $result->fetch_assoc();
if ($row['total'] >= 40) {
    die("Sorry, all 40 seats are booked.");
}

// Insert booking
$sql = "INSERT INTO bannerghatta (name, tour, validation_date, seat_type, validation_time)
        VALUES ('$name', '$tour', '$date', '$seat_type', '$validation_time')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;

    // Load ticket template
    $image = imagecreatefrompng("assets/images/Ticket4.png");
    $text_color = imagecolorallocate($image, 0, 0, 0);
    $font_size = 10;
    $x = 50;   // X-position in the beige area (adjust as needed)
    $y = 600;  // Y-starting point for text in the blank space
    $gap = 35; // Line spacing

    imagestring($image, $font_size, 40, $y, "Booking Confirmation", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Booking ID: $last_id", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Name: $name", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Tour: $tour", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Date: $date", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Seat Type: $seat_type", $text_color); $y += $gap;
    imagestring($image, $font_size, 40, $y, "Valid Till: $validation_time", $text_color);

    $ticket_path = "assets/images/Ticket4_$last_id.png";
    imagepng($image, $ticket_path);
    imagedestroy($image);

    header("Location: bannerghattabooking.php?id=$last_id");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

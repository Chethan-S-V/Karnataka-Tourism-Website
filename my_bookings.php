<?php
session_start();
if (!isset($_SESSION['user_email'])) die("Please log in.");

include "db_config.php";
$email = $_SESSION['user_email'];

$stmt = $conn->prepare("SELECT id, tour, validation_date, seat_type, validation_time FROM bookings WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
?>

<h2>Your Tickets</h2>
<?php
if ($res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $img = "assets/images/Ticket4_" . $row['id'] . ".png";
        echo "<div>";
        if (file_exists($img)) {
            echo "<img src='$img' width='300'><br>";
        } else {
            echo "Ticket image not found.<br>";
        }
        echo "Tour: " . $row['tour'] . "<br>";
        echo "Date: " . $row['validation_date'] . "<br><br></div>";
    }
} else {
    echo "No bookings found.";
}
?>

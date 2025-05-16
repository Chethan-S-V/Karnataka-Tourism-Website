<?php
// Connect database
$conn = new mysqli('localhost', 'root', '', 'karnatism_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$booking_id = $_GET['booking_id'];

$sql = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Invalid Booking ID.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Karnatism Ticket</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .ticket {
            width: 800px;
            height: 300px;
            background: white;
            border: 2px dashed #333;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        .top {
            background: url('travel-icons.png') no-repeat center;
            background-size: contain;
            height: 80px;
            text-align: center;
            padding-top: 10px;
            font-size: 30px;
            font-weight: bold;
            color: #333;
        }
        .ticket-body {
            display: flex;
            padding: 20px;
        }
        .left, .right {
            flex: 1;
        }
        .left {
            border-right: 2px dashed #aaa;
            padding-right: 20px;
        }
        .right {
            padding-left: 20px;
        }
        .details {
            margin-bottom: 15px;
        }
        .details strong {
            display: inline-block;
            width: 150px;
        }
        .bottom {
            position: absolute;
            bottom: 10px;
            left: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="ticket">
    <div class="top">
        Karnatism
    </div>
    <div class="ticket-body">
        <div class="left">
            <div class="details"><strong>Passenger:</strong> <?php echo $row['passenger_name']; ?></div>
            <div class="details"><strong>Destination:</strong> <?php echo $row['destination']; ?></div>
            <div class="details"><strong>Travel Date:</strong> <?php echo $row['travel_date']; ?></div>
            <div class="details"><strong>Departure Time:</strong> <?php echo $row['departure_time']; ?></div>
        </div>
        <div class="right">
            <div class="details"><strong>Travel Type:</strong> <?php echo $row['travel_type']; ?></div>
            <div class="details"><strong>Valid Till:</strong> <?php echo $row['valid_till']; ?></div>
            <div class="details"><strong>Seat No:</strong> <?php echo $row['seat_no']; ?></div>
            <div class="details"><strong>Ticket No:</strong> <?php echo $row['ticket_no']; ?></div>
        </div>
    </div>
    <div class="bottom">
        Thank you for choosing Karnatism Tourism
    </div>
</div>

</body>
</html>

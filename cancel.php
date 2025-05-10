<?php
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $conn = new mysqli('localhost', 'root', '', 'karnatism');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the booking exists and isn't already cancelled
    $check = "SELECT status FROM bookings WHERE id = $id";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();

        if ($row['status'] === 'cancelled') {
            $message = "Ticket is already cancelled.";
            $type = "warning";
        } else {
            $sql = "UPDATE bookings SET status = 'cancelled' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $message = "Ticket successfully cancelled.";
                $type = "success";
            } else {
                $message = "Error cancelling ticket.";
                $type = "error";
            }
        }
    } else {
        $message = "Booking not found.";
        $type = "error";
    }

    $conn->close();
} else {
    $message = "No ticket ID provided.";
    $type = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #fdfbfb, #ebedee);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success { color: green; }
        .error { color: red; }
        .warning { color: orange; }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2 class="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars($message) ?></h2>
        <?php if (isset($id)): ?>
            <a href="booked.php?id=<?= htmlspecialchars($id) ?>">Go back to Ticket</a>
        <?php else: ?>
            <a href="index.html">Go to Home</a>
        <?php endif; ?>
    </div>
</body>
</html>

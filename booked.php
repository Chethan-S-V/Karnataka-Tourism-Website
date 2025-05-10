<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'karnatism');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM bookings WHERE id = $id";
    $result = $conn->query($sql);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Your Ticket</title>
        <meta http-equiv="refresh" content="10;url=index2.html">
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                margin-top: 50px;
                background: #f7f7f7;
            }
            img {
                max-width: 320px;
                border: 1px solid #ccc;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            button {
                margin-top: 20px;
                padding: 10px 20px;
                font-size: 14px;
                background: #dc3545;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background: #c82333;
            }
            #countdown {
                font-weight: bold;
                color: #333;
            }
        </style>
        <script>
            let timeLeft = 10;
            function updateCountdown() {
                if (timeLeft > 0) {
                    document.getElementById("countdown").innerText = timeLeft + " seconds";
                    timeLeft--;
                    setTimeout(updateCountdown, 1000);
                }
            }
            window.onload = updateCountdown;
        </script>
    </head>
    <body>
    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (isset($row['status']) && $row['status'] === 'cancelled') {
            echo "<h1>Ticket Cancelled</h1>";
        } else {
            echo "<h1>Your Ticket</h1>";

            $ticket_path = "assets/images/Ticket4_" . $row['id'] . ".png";
            if (file_exists($ticket_path)) {
                echo "<img src='$ticket_path' alt='Booking Ticket'><br><br>";
            } else {
                echo "<p>Ticket image not found.</p>";
            }

            echo "<form method='POST' action='cancel.php'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit'>Cancel Ticket</button>
                  </form>";

            echo "<p>You will be redirected to the home page in <span id='countdown'>10 seconds</span>...</p>";
        }
    } else {
        echo "<p>Booking not found.</p>";
    }

    $conn->close();
}
?>
</body>
</html>

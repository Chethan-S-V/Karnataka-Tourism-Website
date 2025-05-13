<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = new mysqli('localhost', 'root', '', 'karnatism');
    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

    $sql = "SELECT * FROM hampi_temples WHERE id = $id";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Ticket</title>
    <meta http-equiv="refresh" content="120;url=index2.html"> <!-- Redirect after 120 seconds -->
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
        .download-btn {
            background: #007bff;
            margin-left: 10px;
        }
        .download-btn:hover {
            background: #0056b3;
        }
        .ticket-info {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: linear-gradient(to right, #ffe6e6, #fff);
            border: 2px solid #ffcccc;
            border-radius: 10px;
            color: #990000;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.6;
            box-shadow: 0 0 10px rgba(255, 0, 0, 0.1);
        }
        .button-group {
            margin-top: 20px;
        }
        #countdown {
            font-weight: bold;
            color: #333;
        }
    </style>
    <script>
        let timeLeft = 120;
        function updateCountdown() {
            if (timeLeft > 0) {
                document.getElementById("countdown").innerText = timeLeft + " seconds";
                timeLeft--;
                setTimeout(updateCountdown, 1000);
            }
        }

        function downloadAndRedirect(filePath) {
            const link = document.createElement('a');
            link.href = filePath;
            link.download = filePath.split('/').pop(); // Get filename
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Redirect after short delay
            setTimeout(() => {
                window.location.href = "index2.html";
            }, 1000);
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

            echo "<div class='button-group'>
                    <form method='POST' action='templescancel.php' style='display:inline-block;'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit'>Cancel Ticket</button>
                    </form>
                    <button onclick=\"downloadAndRedirect('$ticket_path')\" class='download-btn'>Download Ticket</button>
                  </div>";

            echo "<p class='ticket-info'>Once the ticket is confirmed, the amount is non-refundable and the booking cannot be canceled — however, you have a 2-minute window to cancel after confirmation. You will be redirected to the home page in <span id='countdown'>120 seconds</span>...</p>";
        }
    } else {
        echo "<p>Booking not found.</p>";
    }

    $conn->close();
}
?>
</body>
</html>

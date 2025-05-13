<?php
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $conn = new mysqli('localhost', 'root', '', 'karnatism');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the booking exists
    $check = "SELECT * FROM hampi_temples WHERE id = $id";
    $res = $conn->query($check);

    if ($res->num_rows > 0) {
        // Booking exists — delete it
        $sql = "DELETE FROM hampi_temples WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            // Reorder IDs to stay continuous
            $conn->query("SET @count = 0");
            $conn->query("UPDATE hampi_temples SET id = @count:=@count+1");
            $conn->query("ALTER TABLE hampi_temples AUTO_INCREMENT = 1");

            $message = "Ticket successfully cancelled and deleted.";
            $type = "success";
        } else {
            $message = "Error deleting the ticket.";
            $type = "error";
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
        .success {
            color: green;
        }
        .error {
            color: red;
        }
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
        <h2 class="<?= htmlspecialchars($type) ?>"><?= $message ?></h2>
        <a href="index2.html">Go back to Home</a>
    </div>
</body>
</html>

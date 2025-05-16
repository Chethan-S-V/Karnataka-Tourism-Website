<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

require_once 'db.php'; // connects to "karnatism" DB

$admin_email = $_SESSION['admin_email'];
$location = $_GET['location'] ?? null;

// Mapping of location names to corresponding table names
$locationTables = [
    'Kudremukh' => 'kudremukh',
    'Gokarna' => 'gokarna',
    'Bandipur' => 'bandipur',
    'Hampi' => 'hampi',
    'DK Temples' => 'dk_temples',
    'DakshinaKannada' => 'dk'
];

function loadBookings($conn, $table) {
    $bookings = [];
    $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table); // sanitize table name

    $sql = "SELECT * FROM `$table`";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }

    return $bookings;
}

$bookings = [];
if ($location && isset($locationTables[$location])) {
    $tableName = $locationTables[$location];
    $bookings = loadBookings($conn, $tableName);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <style>
        body {
            font-family: Arial;
            background: #e6f2ff;
            padding: 30px;
            text-align: center;
        }

        .dashboard {
            background: white;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 90%;
            max-width: 1000px;
            position: relative;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            padding: 10px 15px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        .buttons a {
            padding: 10px 20px;
            margin: 10px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .buttons a:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            word-break: break-word;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <a class="logout-btn" href="admin_view.php">Back</a>

        <h1>Bookings Dashboard</h1>
        <p>Logged in as: <strong><?= htmlspecialchars($admin_email) ?></strong></p>

        <div class="buttons">
            <a href="view_bookings.php?location=Kudremukh">Kudremukh</a>
            <a href="view_bookings.php?location=Gokarna">Gokarna</a>
            <a href="view_bookings.php?location=Bandipur">Bandipur</a>
            <a href="view_bookings.php?location=Hampi">Hampi</a>
            <a href="view_bookings.php?location=DK Temples">DK Temples</a>
            <a href="view_bookings.php?location=DakshinaKannada">DakshinaKannada</a>
        </div>

        <?php if ($location): ?>
            <h2><?= htmlspecialchars($location) ?> Bookings</h2>
            <?php if (count($bookings) > 0): ?>
                <table>
                    <tr>
                        <?php foreach (array_keys($bookings[0]) as $col): ?>
                            <th><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $col))) ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <?php foreach ($booking as $value): ?>
                                <td><?= htmlspecialchars($value) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No bookings found for <?= htmlspecialchars($location) ?>.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

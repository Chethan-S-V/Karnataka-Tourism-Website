<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit;
}

require_once 'db.php'; // assumes this connects to "karnatism" DB

$admin_email = $_SESSION['admin_email'];
$selected = $_GET['view'] ?? null;

function loadUsers($conn, $table)
{
    $users = [];
    $table = mysqli_real_escape_string($conn, $table); // sanitize table name

    $sql = "SELECT * FROM `$table`";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}

$users = [];
if (in_array($selected, ['user_login', 'contact_messages', 'bookings'])) { // Added 'contact_messages' and 'bookings'
    $users = loadUsers($conn, $selected);
}

if ($selected === 'bookings') {
    header("Location: view_bookings.php");
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1000px;
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

        .logout {
            margin-top: 20px;
            background: #dc3545;
        }

        .logout:hover {
            background: #c82333;
        }

        .user-list {
            margin-top: 30px;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: auto;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            word-break: break-word;
            min-width: 100px;
        }

        th {
            background-color: #f2f2f2;
        }

        h3 {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <h1>Welcome, Admin</h1>
        <p>Logged in as: <strong><?= htmlspecialchars($admin_email) ?></strong></p>

        <div class="buttons">
            <a href="admin_view.php?view=user_login">User Login</a>
            <a href="admin_view.php?view=contact_messages">Contact Messages</a>
            <a href="admin_view.php?view=bookings">Bookings</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>

        <?php if ($selected): ?>
            <div class="user-list">
                <h3><?= ucfirst(str_replace('_', ' ', $selected)) ?> Users</h3>
                <?php if (count($users) > 0): ?>
                    <?php if ($selected === 'user_login'): ?>
                        <table>
                            <tr>
                                <?php foreach (array_keys($users[0]) as $col): ?>
                                    <th><?= htmlspecialchars(ucfirst($col)) ?></th>
                                <?php endforeach; ?>
                            </tr>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <?php foreach ($user as $value): ?>
                                        <td><?= htmlspecialchars($value) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <<?php elseif ($selected === 'contact_messages'): ?>
                            <table>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                </tr>
                                <?php foreach ($users as $message): ?>
                                    <tr>
                                    <td><?= htmlspecialchars($message['id']) ?></td>
                                        <td><?= htmlspecialchars($message['name']) ?></td>
                                        <td><?= htmlspecialchars($message['email']) ?></td>
                                        <td><?= htmlspecialchars($message['message']) ?></td>
                                        <td><?= htmlspecialchars($message['submitted_at'] ?? 'N/A') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>

                        <?php else: ?>
                            <ul>
                                <?php foreach ($users as $user): ?>
                                    <li>Name: <?= htmlspecialchars($user['name']) ?>, Email: <?= htmlspecialchars($user['email']) ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>No users found in this category.</p>
                    <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
<?php
include "connect.php"; // DB connection

$successMessage = "";
$errorMessage = "";

if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    $errorMessage = "Invalid request.";
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if (empty($password) || empty($confirm)) {
        $errorMessage = "All fields are required.";
    } elseif ($password !== $confirm) {
        $errorMessage = "Passwords do not match.";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE user_login SET password=? WHERE email=?");
        $stmt->bind_param("ss", $hashed, $email);

        if ($stmt->execute()) {
            $successMessage = "Password updated successfully! <a href='login.php'>Login now</a>";
        } else {
            $errorMessage = "Something went wrong. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="fp.css"> <!-- Use same styles -->
</head>
<body>
<div class="wrapper">
    <h2>Reset Password</h2>

    <?php if (!empty($successMessage)): ?>
        <p style="color: green;"><?= $successMessage ?></p>
    <?php else: ?>
        <form method="POST" action="">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter new password</label>
            </div>
            <div class="input-field">
                <input type="password" name="confirm_password" required>
                <label>Confirm new password</label>
            </div>
            <button type="submit">Reset Password</button>
        </form>

        <?php if (!empty($errorMessage)): ?>
            <p style="color: red;"><?= $errorMessage ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>

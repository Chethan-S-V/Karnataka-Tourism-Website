<?php
include "connect.php";

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (empty($email)) {
        $errorMessage = "Please enter your email.";
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Instead of sending email, just show reset link
            $successMessage = "Account found! <br> 
            <a href='rp.php?email=" . urlencode($email) . "'>Click here to reset your password</a>";
        } else {
            $errorMessage = "No account found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="fp.css">
</head>
<body>
<div class="wrapper">
    <h2>Forgot Password</h2>
    <form method="POST" action="">
        <div class="input-field">
            <input type="email" name="email" required>
            <label>Enter your email</label>
        </div>
        <button type="submit">Send Reset Link</button>
        <div class="register">
            <p>Remembered your password? <a href="login.php">Login</a></p>
        </div>
    </form>

    <?php if (!empty($successMessage)): ?>
        <p style="color: lightgreen; margin-top: 20px;"><?= $successMessage ?></p>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <p style="color: red; margin-top: 20px;"><?= $errorMessage ?></p>
    <?php endif; ?>
</div>
</body>
</html>

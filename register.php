<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="reg.css">
</head>
<body>
<div class="wrapper">
      <h2>Sign Up</h2>
      <form method="POST" action="register.php" >
      <!-- Full Name Field -->
      <div class="input-field">
        <input type="text" name="name" required>
        <label>Enter your name</label>
      </div>
      <!-- Email Field -->
      <div class="input-field">
        <input type="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <!-- Password Field -->
      <div class="input-field">
        <input type="password" name="password" required>
        <label>Create password</label>
      </div>
      <!-- Confirm Password Field -->
      <div class="input-field">
        <input type="password" name="confirm_password" required>
        <label>Confirm password</label>
      </div>
      <!-- Terms and Conditions -->
      <div class="terms">
        <label for="agree">
          <input type="checkbox" id="agree" required>
          <p>I agree to the terms & conditions</p>
        </label>
      </div>
      <button type="submit" name="signup">SignUp</button>
      <div class="login">
        <p>Already have an account? <a href="login.php">SignIn</a></p>
      </div>
    </form>
  </div>
<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm_password"];

    if ($password !== $confirm) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $checkQuery = "SELECT * FROM user_login WHERE email=?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO user_login (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed);
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

</body>
</html>
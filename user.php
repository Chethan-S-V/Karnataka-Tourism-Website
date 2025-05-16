<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, name, password FROM user_login WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["name"] = $name;

            // Redirect to index2.html
            header("Location: index2.html");
            exit;
        } else {
            echo "<p style='color:red;text-align:center;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color:red;text-align:center;'>User not found.</p>";
    }
}
?>

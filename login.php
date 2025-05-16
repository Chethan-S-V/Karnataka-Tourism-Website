<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
     <link rel="stylesheet" href="login.css">
</head>
<body>
  <div class="wrapper">
      <h2>SignIn</h2>
      <form action="user.php"method="POST">
        <div class="input-field">
        <input type="text" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required>
        <label>Enter your password</label>
      </div>
      <div class="forget">
        <a href="fp.php">Forgot password?</a>
      </div>
      <button type="submit" name="signin">Sign In</button>
      <div class="register">
        <p>Don't have an account? <a href="register.php">SignUp</a></p>
      </div>
    </form>
  </div>

  
</body>
</html>
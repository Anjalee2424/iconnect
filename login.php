<?php
$appName = "iConnect";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  // Dummy authentication for demonstration
  if ($username === 'test' && $password === 'test') {
    header('Location: mypage/');
    exit;
  } else {
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>iConnect Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/login.css" />
</head>

<body>
  <?php include 'components/header.php'; ?>

  <div class="container">
    <div class="login-box">
      <h2>Welcome to iConnect</h2>
      <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
    </div>
  </div>

  <!-- Top-right Gradient Blob -->
  <svg class="blob top" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <linearGradient id="mostlyPurple" x1="0%" y1="0%" x2="100%" y2="100%">
        <stop offset="0%" stop-color="#7c4dff" />
        <stop offset="50%" stop-color="#9c4dff" />
        <stop offset="85%" stop-color="#c47dff" />
        <stop offset="100%" stop-color="#fcaee4" />
      </linearGradient>
    </defs>
    <path fill="url(#mostlyPurple)" d="
      M450 180 
      C420 140 400 110 350 130 
      C310 90 260 120 220 150 
      C180 120 140 160 160 200 
      C130 210 140 260 190 270 
      C180 300 210 330 260 320 
      C290 350 340 340 370 300 
      C420 310 460 280 450 200 
    " />
  </svg>

  <!-- Bottom-left Gradient Blob -->
  <svg class="blob bottom" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg">
    <path fill="url(#mostlyPurple)" d="
      M450 180 
      C420 140 400 110 350 130 
      C310 90 260 120 220 150 
      C180 120 140 160 160 200 
      C130 210 140 260 190 270 
      C180 300 210 330 260 320 
      C290 350 340 340 370 300 
      C420 310 460 280 450 200 
    " />
  </svg>

</body>

</html>
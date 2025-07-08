<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>iConnect Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff;
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    .container {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 40px 30px;
      border-radius: 20px;
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .login-box h2 {
      color: #7c4dff;
      margin-bottom: 30px;
      font-size: 28px;
      font-weight: 600;
    }

    .login-box input {
      width: 100%;
      padding: 12px 15px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 16px;
      outline: none;
      transition: 0.3s;
    }

    .login-box input:focus {
      border-color: #7c4dff;
      box-shadow: 0 0 0 3px rgba(124, 77, 255, 0.2);
    }

    .login-box button {
      background: #7c4dff;
      color: #fff;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-box button:hover {
      background: #651fff;
    }

    .login-box p {
      margin-top: 15px;
      font-size: 14px;
    }

    .login-box a {
      color: #7c4dff;
      text-decoration: none;
      font-weight: 500;
    }

    .blob {
      position: absolute;
      z-index: 0;
      pointer-events: none;
    }

    .blob.top {
      top: -400px;
      right: 200px;
      width: 2000px;
      height: 1000px;
    }

    .blob.bottom {
      bottom: -300px;
      left: 300px;
      width: 2000px;
      height: 1000px;
    }
  </style>
</head>
<body>

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

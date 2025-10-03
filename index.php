<?php
// ==========================
// Basic PHP Setup
// ==========================
session_start();
$appName = "iConnect";
$year = date("Y");

// Example session check (optional)
$isLoggedIn = isset($_SESSION["user"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $appName; ?></title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #f9f9ff, #f1f0ff);
      color: #222;
    }
    header {
      display: flex; justify-content: space-between; align-items: center;
      padding: 20px 60px;
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      position: sticky; top: 0; z-index: 1000;
    }
    header .logo {
      font-size: 22px; font-weight: bold; color: #7c4dff;
    }
    header nav a {
      margin-left: 25px; text-decoration: none; color: #333;
      font-size: 15px; transition: color 0.3s;
    }
    header nav a:hover { color: #7c4dff; }
    .hero {
      display: flex; justify-content: space-between; align-items: center;
      padding: 80px 60px; gap: 40px;
    }
    .hero-text { max-width: 500px; animation: fadeInUp 1s ease; }
    .hero-text h1 { font-size: 52px; font-weight: 800; margin-bottom: 20px; }
    .hero-text h1 span { color: #7c4dff; }
    .hero-text p { font-size: 18px; margin-bottom: 35px; color: #555; line-height: 1.6; }
    .hero-text button {
      background: linear-gradient(135deg, #7c4dff, #5c2fff);
      color: #fff; padding: 15px 35px; border: none; border-radius: 30px;
      font-size: 16px; cursor: pointer;
      box-shadow: 0 6px 15px rgba(124, 77, 255, 0.3);
      transition: all 0.3s ease;
    }
    .hero-text button:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(124, 77, 255, 0.4);
    }
    .hero-image img {
      max-width: 450px; width: 100%;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      animation: fadeIn 1.2s ease;
    }
    footer {
      text-align: center; padding: 20px;
      background: #fff; margin-top: 50px;
      box-shadow: 0 -4px 10px rgba(0,0,0,0.05);
      font-size: 14px; color: #555;
    }
    @keyframes fadeInUp { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
    @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
    @media (max-width: 900px) {
      .hero { flex-direction: column; text-align: center; padding: 60px 20px; }
      .hero-text h1 { font-size: 40px; }
      .hero-image img { margin-top: 30px; }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <header>
    <div class="logo">🌎 <?php echo $appName; ?></div>
    <nav>
      <a href="#about">About</a>
      <a href="#">Web Version</a>
      <a href="#">English</a>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Talk to the <span>World</span></h1>
      <p>Learn a language for free by chatting with native speakers around the globe. Start meaningful conversations and make real connections.</p>

      <?php if ($isLoggedIn): ?>
        <button id="dashboardBtn">Go to Dashboard</button>
      <?php else: ?>
        <button id="startBtn">Get Started Now</button>
      <?php endif; ?>
    </div>

  <!-- Right side (just one image) -->
  <div class="hero-image">
    <img src="images/hello1.png" alt="App preview" 
         style="max-width:450px; width:100%; height:auto; border-radius:12px;">
  </div>
</section>

  <!-- About Section -->
  <section id="about" style="padding:60px; text-align:center;">
    <h2 style="font-size:28px; margin-bottom:20px; color:#7c4dff;">About <?php echo $appName; ?></h2>
    <p style="max-width:600px; margin:0 auto; font-size:16px; color:#555; line-height:1.6;">
      <?php echo $appName; ?> is a multilingual communication platform where you can connect with people from different cultures, learn languages naturally, and make global friendships.
    </p>
  </section>

  <!-- Footer -->
  <footer>
    &copy; <?php echo $year; ?> <?php echo $appName; ?>. All rights reserved.
  </footer>

  <!-- JavaScript -->
  <script>
    // Get Started button
    const startBtn = document.getElementById("startBtn");
    if(startBtn){
      startBtn.addEventListener("click", function() {
        alert("Redirecting you to login...");
        window.location.href = "login.php";
      });
    }

    // Dashboard button
    const dashboardBtn = document.getElementById("dashboardBtn");
    if(dashboardBtn){
      dashboardBtn.addEventListener("click", function() {
        window.location.href = "dashboard.php";
      });
    }

    // Smooth scroll for nav links
    document.querySelectorAll("header nav a[href^='#']").forEach(anchor => {
      anchor.addEventListener("click", function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute("href")).scrollIntoView({
          behavior: "smooth"
        });
      });
    });
  </script>
</body>
</html>

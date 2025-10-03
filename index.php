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
  <link rel="stylesheet" href="css/default.css" />
</head>
<body>
  <!-- Navbar -->
  <?php include 'components/header.php'; ?>

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

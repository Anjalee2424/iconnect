<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Language Talks</title>
  <link rel="stylesheet" href="../css/mypage.css">
</head>
<body>

  <!-- Header -->
  
  <div class="header">iConnect</div>

  <!-- Chat List -->
  <ul class="chat-list">
    <li class="chat-item">
      <img src="https://via.placeholder.com/52" class="avatar" alt="avatar">
      <div class="chat-info">
        <div class="chat-name">
          <a href="chat.php">
            Alice <span class="crown">👑</span>
          </a>
          
        </div>
        <div class="chat-message">Here's one of our new, favorite wa...</div>
        <a href="chat.php" class="button">Chat</a>
      </div>
      <div class="chat-time">7/7/17</div>
    </li>

    <li class="chat-item">
      <img src="https://via.placeholder.com/52" class="avatar" alt="avatar">
      <div class="chat-info">
        <div class="chat-name">Tommy</div>
        <div class="chat-message">好的好的</div>
      </div>
      <div class="chat-time">7/3/17</div>
    </li>
  </ul>

  <!-- Bottom Navigation -->
  <?php include '../components/user_menu.php'; ?>

</body>
</html>

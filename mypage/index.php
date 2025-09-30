<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Language Talks</title>
  <style>
    body {
      margin: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f3f6fa;
      color: #333;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    /* Header with purple gradient */
    .header {
      background: linear-gradient(
        90deg,
        #7c4dff 0%,
        #9c4dff 50%,
        #c47dff 85%,
        #fcaee4 100%
      );
      color: white;
      padding: 18px;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 0.5px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    /* Chat list */
    .chat-list {
      list-style: none;
      margin: 0;
      padding: 15px;
    }

    .chat-item {
      display: flex;
      align-items: center;
      padding: 14px;
      margin-bottom: 12px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .chat-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    }

    .avatar {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      margin-right: 14px;
      object-fit: cover;
      border: 2px solid #c47dff44;
    }

    .chat-info {
      flex: 1;
    }

    .chat-name {
      font-weight: 600;
      font-size: 16px;
      display: flex;
      align-items: center;
      color: #222;
    }

    .crown {
      margin-left: 6px;
      color: goldenrod;
      font-size: 15px;
    }

    .chat-message {
      font-size: 14px;
      color: #666;
      margin-top: 3px;
    }

    .chat-time {
      font-size: 12px;
      color: #999;
      margin-left: 10px;
      white-space: nowrap;
    }

    /* Bottom nav */
    .bottom-nav {
      display: flex;
      justify-content: space-around;
      background: #fff;
      border-top: 1px solid #ddd;
      position: fixed;
      bottom: 0;
      width: 100%;
      padding: 10px 0;
      font-size: 13px;
      box-shadow: 0 -2px 6px rgba(0,0,0,0.05);
    }

    .nav-item {
      text-align: center;
      color: #777;
      transition: color 0.3s;
    }

    .nav-item:hover {
      color: #9c4dff;
    }

    .nav-item.active {
      color: #9c4dff;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <?php include '../components/header.php'; ?>

  <!-- Chat List -->
  <ul class="chat-list">
    <li class="chat-item">
      <img src="https://via.placeholder.com/52" class="avatar" alt="avatar">
      <div class="chat-info">
        <div class="chat-name">
          <a href="chat.php">
            iConnect Team <span class="crown">👑</span>
          </a>
          
        </div>
        <div class="chat-message">Here's one of our new, favorite wa...</div>
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

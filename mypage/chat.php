<?php
require_once __DIR__ . '/../lib/lang.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <title>Socket.io Chat</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/chat.css" />
</head>

<body class="bg-gray-100 h-screen flex flex-col items-center p-6">
  <div class="w-full max-w-md mb-4 flex items-center justify-between">

    <div>
      <label for="langSelect" class="sr-only">Language</label>
      <div>
        <label for="langSelect" class="sr-only">Language</label>
        <select id="langSelect" class="border rounded px-2 py-1">
          <?php foreach (Lang::langs as $code => $info): ?>
            <option value="<?= htmlspecialchars($code) ?>" data-lang="<?= $info['lang'] ?>">
              <?= htmlspecialchars($info['label']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <div
    id="chat-box"
    class="chat-messages w-full max-w-md flex-1 overflow-y-auto border rounded-lg bg-white shadow p-4 mb-4">
  </div>

  <form
    id="chatForm"
    class="w-full max-w-md flex space-x-2"
    autocomplete="off">
    <input
      id="msgInput"
      type="text"
      placeholder="メッセージを入力..."
      data-i18n-placeholder="placeholder_msg"
      class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
    <button
      type="submit"
      id="sendBtn"
      class="bg-blue-500 text-white rounded-lg px-4 hover:bg-blue-600 transition"
      data-i18n="send_button">
      送信
    </button>
    <button
      type="button"
      id="micBtn"
      class="bg-gray-300 text-black rounded-lg px-3 hover:bg-gray-400">
      🎤
    </button>
  </form>

  <script src="../js/env.js" defer></script>
  <script src="../js/app.js" defer></script>
</body>

</html>
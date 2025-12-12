<?php
require_once '../app.php';

$user_id = $_SESSION['user_id'] ?? null;
$friend_id = $_GET['friend_id'] ?? null;

if (!$user_id || !$friend_id) {
    header('Location: ../login.php');
    exit;
}


// 自分の情報を取得
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ともだちの情報を取得
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$friend_id]);
$friend = $stmt->fetch(PDO::FETCH_ASSOC);

// 🔥 チャットルームを取得 or 作成する
// 既存ルームを探す
$room = existsChatRoom($pdo, $user_id, $friend_id);
if (!$room || empty($room["id"])) {
    // ルームがなければ新規作成
    $sql = "INSERT INTO chat_rooms (id, user1_id, user2_id) VALUES (UUID(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $friend_id]);

    // 作成したルームを再取得
    $room = existsChatRoom($pdo, $user_id, $friend_id);
}

$room_id = $room["id"];

function existsChatRoom($pdo, $user1_id, $user2_id)
{
    $sql = "
        SELECT id 
        FROM chat_rooms
        WHERE (user1_id = ? AND user2_id = ?)
           OR (user1_id = ? AND user2_id = ?)
        LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user1_id, $user2_id, $user2_id, $user1_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    return $room;
}
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
    <h2>Chart Room</h2>
    <div class="text-xs">
        <div class="flex">
            <span>HOST:</span>
            <div id="host"></div>
        </div>
        <div class="flex">
            <span>PATH:</span>
            <div id="path"></div>
        </div>
        <div class="flex">
            <span>ROOM ID:</span>
            <div id="room_id"><?= $room_id ?></div>
        </div>
        <div class="flex">
            <span>FRIEND ID:</span>
            <div id="friend_id"><?= $friend_id ?></div>
        </div>
    </div>

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

    <script>
        const CHAT_HOST = '<?= CHAT_HOST ?>';
        const CHAT_PATH = '<?= CHAT_PATH ?>';
        const API_HOST = '<?= API_HOST ?>';
        const ROOM_ID = '<?= $room_id ?>';
        const USER_ID = <?= $user_id ?>;
        const USER_NAME = '<?= htmlspecialchars($user['username']) ?>';
        const USER_NICKNAME = '<?= htmlspecialchars($user['nickname']) ?>';
        const FRIEND_ID = <?= $friend_id ?>;
    </script>
    <script src="../js/app.js"></script>
</body>

</html>
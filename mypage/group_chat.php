<?php
require_once '../app.php';
require_once '../rooms.php';

$user_id = $_SESSION['user_id'] ?? null;
$room_id = $_GET['room_id'] ?? null;

if (!$user_id || !$room_id) {
    header('Location: ../login.php');
    exit;
}

$room = getRoomById($room_id);
if (!$room) {
    header('Location: chat_room.php');
    exit;
}

// 自分の情報を取得
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <title>iConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/chat.css" />
</head>

<body class="bg-gray-100 h-screen flex flex-col items-center p-6">
    <h1 class="text-2xl font-bold mb-4 border-b flex justify-between items-center"><?= htmlspecialchars($room['name']) ?></h1>

    <div class="flex flex-1 gap-4 w-full max-w-6xl mx-auto overflow-hidden">

        <div class="flex-1 flex flex-col min-w-0">
            <div class="mb-2">
                <select id="langSelect" class="border rounded px-2 py-1 text-sm">
                    <?php foreach (Lang::langs as $code => $info): ?>
                        <option value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($info['label']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div id="chat-box" class="flex-1 overflow-y-auto border rounded-lg bg-white shadow p-4 mb-4">
            </div>

            <form id="chatForm" class="flex space-x-2" autocomplete="off">
                <input id="msgInput" type="text" placeholder="メッセージを入力..."
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                <button type="submit" id="sendBtn" class="bg-blue-500 text-white rounded-lg px-6 hover:bg-blue-600 transition">送信</button>
                <button type="button" id="micBtn" class="bg-gray-300 text-black rounded-lg px-3 hover:bg-gray-400">🎤</button>
            </form>
        </div>

        <div class="w-48 md:w-64 flex flex-col border rounded-lg bg-white shadow overflow-hidden">
            <div class="bg-gray-200 px-4 py-2 font-bold text-sm border-b">Join Users</div>
            <div id="userList" class="flex-1 overflow-y-auto p-2 space-y-2">
            </div>
        </div>

    </div>

    <script>
        const CHAT_HOST = '<?= CHAT_HOST ?>';
        const CHAT_PATH = '<?= CHAT_PATH ?>';
        const API_HOST = '<?= API_HOST ?>';
        const ROOM_ID = '<?= $room_id ?>';
        const userId = <?= $user_id ?>;
        const USER_NAME = '<?= htmlspecialchars($user['username']) ?>';
        const USER_NICKNAME = '<?= htmlspecialchars($user['nickname']) ?>';
    </script>
    <script src="../js/app.js"></script>
</body>

</html>
<?php
require_once '../app.php';
require_once '../rooms.php';

$user_id = $_SESSION['user_id'] ?? null;
$friend_id = $_GET['friend_id'] ?? null;

if (!$user_id) {
    header('Location: ../login.php');
    exit;
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
</head>

<body class="bg-gray-100 flex flex-col p-6">
    <h1 class="text-2xl font-bold mb-4 border-b flex justify-between items-center">Chat Room</h1>

    <div>
        <ul class="space-y-4">
            <?php foreach ($chat_rooms as $room): ?>
                <li>
                    <a href="group_chat.php?room_id=<?= htmlspecialchars($room['id']) ?>"
                        class="block p-4 bg-white rounded shadow hover:bg-gray-50"
                        target="_blank">
                        <?= htmlspecialchars($room['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>
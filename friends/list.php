<?php
require '../app.php';

$myId = $_SESSION['user_id'];

// 🔥 友だち一覧 + DMルームID + 最新メッセージをまとめて取得
$sql = "
SELECT 
    u.id AS friend_id,
    u.username,
    u.picture,
    u.self_intro,
    cr.id AS room_id
FROM friends f
JOIN users u ON f.friend_id = u.id
LEFT JOIN chat_rooms cr 
    ON (cr.user1_id = :me AND cr.user2_id = u.id)
    OR (cr.user1_id = u.id AND cr.user2_id = :me)
WHERE f.user_id = :me
ORDER BY f.created_at DESC;
";


$stmt = $pdo->prepare($sql);
$stmt->execute([":me" => $myId]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Friends List</title>
    <link rel="stylesheet" href="../css/mypage.css" />
    <link rel="stylesheet" href="../css/friends.css" />
</head>

<body>

    <div class="header">Friends</div>

    <?php include '../components/chat_list.php'; ?>

    <?php include '../components/user_menu.php'; ?>

</body>

</html>
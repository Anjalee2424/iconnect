<?php
require '../db.php';
session_start();

$currentUserId = $_SESSION['user_id'];
$friendId = $_POST['friend_id'];

// すでに友だちか確認
$stmt = $pdo->prepare("
    SELECT * FROM friends 
    WHERE user_id = ? AND friend_id = ?
");
$stmt->execute([$currentUserId, $friendId]);

if ($stmt->rowCount() === 0) {
    // 未登録なら追加
    $stmt = $pdo->prepare("
        INSERT INTO friends (user_id, friend_id)
        VALUES (?, ?)
    ");
    $stmt->execute([$currentUserId, $friendId]);
}

header("Location: ../mypage");
exit;
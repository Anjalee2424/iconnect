<ul class="chat-list">
    <?php foreach ($friends as $f): ?>
        <li class="chat-item">
            <img
                src="../<?= htmlspecialchars($f['picture'] ?? 'default.jpg') ?>"
                class="avatar">

            <div class="chat-info">
                <div class="chat-name"><?= htmlspecialchars($f['nickname']) ?></div>
                <div class="chat-name">(<?= htmlspecialchars($f['username']) ?>)</div>

                <div class="chat-message"><?= htmlspecialchars($f['message'] ?? "No messages yet") ?></div>

                <a class="button"
                    target="_blank"
                    href="<?= $BASE_URL ?>mypage/chat.php?room=<?= $f['room_id'] ?>&friend_id=<?= $f['friend_id'] ?>">
                    Chat
                </a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
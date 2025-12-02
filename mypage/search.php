<?php
require_once '../app.php';

$user_id = $_SESSION['user_id'];

try {
    // users テーブルからデータ取得（必要なカラム名に合わせて変更OK）
    $sql = "SELECT * FROM users WHERE id != :me";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':me' => $user_id]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Partners</title>
    <link rel="stylesheet" href="../css/mypage.css">
    <link rel="stylesheet" href="../css/search.css">
</head>

<body>
    <!-- Header -->
    <h1>Find Partners</h1>

    <div class="conatainer">
        <div class="filters">
            <button class="active" data-filter="all">All</button>
            <button data-filter="serious-learners">Serious Learners</button>
            <button data-filter="nearby">Nearby</button>
            <button data-filter="city">City</button>
        </div>

        <div class="user-profiles">
            <?php if (count($users) > 0): ?>
                <?php foreach ($users as $user): ?>
                    <?php
                    // tags が「serious-learners,travel,fashion」みたいなカンマ区切りなら配列に変換
                    $tagArray = array_map('trim', explode(',', $user['languages_spoken'] ?? ''));
                    ?>
                    <form action="../friends/add.php" method="post">
                        <!-- フレンドID -->
                        <input type="hidden" name="friend_id" value="<?= htmlspecialchars($user['id']) ?>">

                        <div class="profile" data-tags="<?php echo htmlspecialchars(implode(' ', $tagArray)); ?>">
                            <img src="../<?= htmlspecialchars($user['picture'] ?? 'non_avater.svg') ?>?tmp=<?= time() ?>"
                                class="profile-pic-preview"
                                id="profilePreview">
                            <div class="profile-info">
                                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                                <p><?php echo htmlspecialchars($user['self_intro']); ?></p>
                                <div class="tags">
                                    <?php foreach ($tagArray as $tag): ?>
                                        <span><?= $tag ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <button class="connect-btn">Connect</button>
                            </div>
                        </div>
                    </form>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No users found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include '../components/user_menu.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterButtons = document.querySelectorAll('.filters button');
            const profiles = document.querySelectorAll('.profile');

            filterButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const filter = btn.dataset.filter;
                    filterButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    profiles.forEach(profile => {
                        if (filter === 'all' || profile.dataset.tags.includes(filter)) {
                            profile.classList.remove('hide');
                        } else {
                            profile.classList.add('hide');
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>
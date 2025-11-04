<?php
require_once '../lib/lang.php';

session_start();

// Mock user data
$user = [
    'id' => 1,
    'username' => 'javacash',
    'email' => 'javacash@example.com',
    'nickname' => 'Javacash Ağa',
    'password' => '',
    'self_intro' => 'Here to connect with the world! I\'m learning Chinese mostly, but also Farsi Hindi.',
    'department' => 'Language Learning',
    'languages' => ['English', 'Chinese', 'Farsi'],
    'interests' => ['Fashion', 'Netflix', 'Traveling'],
    'profile_pic' => 'user-avatar.jpg'
];

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: user id from session
    $user['id'] = $_POST['id'] ?? $user['id'];
    $user['username'] = $_POST['username'] ?? $user['username'];
    $user['email'] = $_POST['email'] ?? $user['email'];
    $user['nickname'] = $_POST['nickname'] ?? $user['nickname'];
    $user['password'] = $_POST['password'] ?? $user['password'];
    $user['self_intro'] = $_POST['self_intro'] ?? $user['self_intro'];
    $user['department'] = $_POST['department'] ?? $user['department'];

    $user['languages'] = explode(',', $_POST['languages'] ?? implode(',', $user['languages']));
    $user['interests'] = explode(',', $_POST['interests'] ?? implode(',', $user['interests']));

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $uploadDir = 'uploads/users/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        // $filename = $uploadDir . basename($_FILES['profile_pic']['name']);
        $filename = "{$uploadDir}/{$user['id']}.jpg";
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename);
        $user['profile_pic'] = $filename;
    }

    $_SESSION['user'] = $user;
    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - iConnect</title>
    <link rel="stylesheet" href="../css/mypage.css">
</head>

<body>
    <div class="container">
        <h2>Edit Profile</h2>

        <?php if (isset($success)) echo "<div class='success'>{$success}</div>"; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <div>
                <label>Profile Picture</label>
                <img src="<?php echo $user['profile_pic']; ?>" class="profile-pic-preview" id="profilePreview" alt="Profile Picture">
                <input type="file" name="profile_pic" accept="image/*" onchange="previewImage(event)">
            </div>

            <div><label>Username</label><input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required></div>
            <div><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></div>
            <div><label>Password</label><input type="password" name="password" placeholder="Enter new password"></div>
            <div><label>Nickname</label><input type="text" name="nickname" value="<?php echo htmlspecialchars($user['nickname']); ?>"></div>
            <div><label>Self Introduction</label><textarea name="self_intro" rows="4"><?php echo htmlspecialchars($user['self_intro']); ?></textarea></div>
            <div><label>Department</label>
                <input type="text" name="department" value="<?php echo htmlspecialchars($user['department']); ?>">
                <select id="lang-select" class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                    <?php foreach (Lang::langs as $code => $obj): ?>
                        <option value="<?= $code ?>" data-voice="<?= $obj['voice'] ?>">
                            <?= $obj['label'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div>
                <label>Languages Spoken</label>
                <div class="tags-container" id="languagesContainer"></div>
                <input type="hidden" name="languages" id="languagesInput" value="<?php echo implode(',', $user['languages']); ?>">
            </div>

            <div>
                <label>Interests & Hobbies</label>
                <div class="tags-container" id="interestsContainer"></div>
                <input type="hidden" name="interests" id="interestsInput" value="<?php echo implode(',', $user['interests']); ?>">
            </div>

            <button type="submit">Save Changes</button>
        </form>

    </div>

    <!-- Bottom Navigation -->
    <?php include '../components/user_menu.php'; ?>

    <script>
        // Image preview
        function previewImage(event) {
            const preview = document.getElementById('profilePreview');
            preview.src = URL.createObjectURL(event.target.files[0]);
        }

        // Tag logic
        function setupTags(containerId, hiddenInputId, initialTags) {
            const container = document.getElementById(containerId);
            const hiddenInput = document.getElementById(hiddenInputId);
            let tags = initialTags.slice();

            function update() {
                container.innerHTML = '';
                tags.forEach((tag, i) => {
                    const span = document.createElement('span');
                    span.textContent = tag;
                    const remove = document.createElement('span');
                    remove.textContent = '×';
                    remove.className = 'remove';
                    remove.onclick = () => {
                        tags.splice(i, 1);
                        update();
                    }
                    span.appendChild(remove);
                    container.appendChild(span);
                });
                const input = document.createElement('input');
                input.type = 'text';
                input.placeholder = 'Add...';
                input.onkeydown = (e) => {
                    if (e.key === 'Enter' && input.value.trim() !== '') {
                        e.preventDefault();
                        tags.push(input.value.trim());
                        input.value = '';
                        update();
                    }
                };
                container.appendChild(input);
                hiddenInput.value = tags.join(',');
            }
            update();
        }

        setupTags('languagesContainer', 'languagesInput', <?php echo json_encode($user['languages']); ?>);
        setupTags('interestsContainer', 'interestsInput', <?php echo json_encode($user['interests']); ?>);
    </script>
</body>

</html>
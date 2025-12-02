<?php
require_once '../app.php';

// =====================================================
// ★ Require login
// =====================================================
if (!isset($_SESSION['user_id'])) {
    die("Not logged in.");
}
$userId = $_SESSION['user_id'];

// =====================================================
// ① Fetch User From DB
// =====================================================
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Convert comma-separated to arrays
$user['languages'] = !empty($user['languages_spoken'])
    ? explode(',', $user['languages_spoken'])
    : [];

$user['interests'] = !empty($user['hobbies'])
    ? explode(',', $user['hobbies'])
    : [];

// =====================================================
// ② UPDATE PROCESS (POST)
// =====================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username   = $_POST['username']   ?? '';
    $nickname   = $_POST['nickname']   ?? '';
    $selfIntro  = $_POST['self_intro'] ?? '';
    $department = $_POST['department'] ?? '';
    $password   = $_POST['password']   ?? '';

    // Comma-separated (already prepared by JS)
    $languages  = $_POST['languages']  ?? '';
    $interests  = $_POST['interests']  ?? '';

    // ================================
    // If password entered → update
    // ================================
    $passwordSql = "";
    $params = [
        ':id'          => $userId,
        ':username'    => $username,
        ':nickname'    => $nickname,
        ':self_intro'  => $selfIntro,
        ':department'  => $department,
        ':languages'   => $languages,
        ':hobbies'     => $interests
    ];

    if (!empty($password)) {
        $passwordSql = ", password = :password";
        $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // ================================
    // Profile Picture Upload
    // ================================
    $picturePath = $user['picture'] ?? '';

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {

        $uploadDir = "../uploads/users";
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = "{$uploadDir}/{$userId}.jpg";
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename);

        // Save path relative to site root
        $picturePath = "uploads/users/{$userId}.jpg";
    }

    $pictureSql = ", picture = :picture";
    $params[':picture'] = $picturePath;

    // ================================
    // UPDATE SQL
    // ================================
    $sql = "
        UPDATE users SET
            username     = :username,
            nickname     = :nickname,
            self_intro   = :self_intro,
            department   = :department,
            languages_spoken = :languages,
            hobbies      = :hobbies
            $passwordSql
            $pictureSql
        WHERE id = :id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Avoid POST duplicate
    header("Location: edit_profile.php?updated=1");
    exit;
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

    <?php if (isset($_GET['updated'])) : ?>
        <div class='success'>Profile updated successfully!</div>
    <?php endif ?>

    <form class="form" action="" method="POST" enctype="multipart/form-data">

        <!-- Profile Picture -->
        <div>
            <label>Profile Picture</label>
            <img src="../<?= htmlspecialchars($user['picture'] ?? 'default.jpg') ?>?tmp=<?= time() ?>"
                class="profile-pic-preview"
                id="profilePreview">
            <input type="file" name="profile_pic" accept="image/*" onchange="previewImage(event)">
        </div>

        <div>
            <label>Username</label>
            <input type="text" name="username"
                value="<?= htmlspecialchars($user['username']) ?>"
                required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password"
                placeholder="Enter new password">
        </div>

        <div>
            <label>Nickname</label>
            <input type="text" name="nickname"
                value="<?= htmlspecialchars($user['nickname']) ?>">
        </div>

        <div>
            <label>Self Introduction</label>
            <textarea name="self_intro" rows="4"><?= htmlspecialchars($user['self_intro']) ?></textarea>
        </div>

        <div>
            <label>Department</label>
            <input type="text" name="department"
                value="<?= htmlspecialchars($user['department']) ?>">
        </div>

        <!-- Languages -->
        <div>
            <label>Languages Spoken</label>

            <select id="langSelect" class="p-2 border border-gray-300 rounded w-full mb-2">
                <option value="">-- Select Language --</option>
                <?php foreach (Lang::langs as $code => $obj): ?>
                    <option value="<?= $code ?>">
                        <?= $obj['label'] ?> (<?= $code ?>)
                    </option>
                <?php endforeach ?>
            </select>

            <button type="button" onclick="addLanguage()" class="add-btn">Add Language</button>

            <div class="tags-container" id="languagesContainer"></div>

            <input type="hidden" name="languages" id="languagesInput"
                value="<?= htmlspecialchars(implode(',', $user['languages'])) ?>">
        </div>

        <!-- Interests -->
        <div>
            <label>Interests & Hobbies</label>
            <div class="tags-container" id="interestsContainer"></div>
            <input type="hidden" name="interests" id="interestsInput"
                value="<?= htmlspecialchars(implode(',', $user['interests'])) ?>">
        </div>

        <button type="submit">Save Changes</button>
    </form>
</div>

<?php include '../components/user_menu.php'; ?>

<script src="../js/lang.js"></script>
</body>
</html>

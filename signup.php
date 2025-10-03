<?php
// require 'db.php';

$error = '';
$username = '';
$nickname = '';
$department = '';
$languages_spoken = '';
$hobbies = '';
$self_intro = '';
$country = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Location: mypage/');
  // $username = trim($_POST['username'] ?? '');
  // $password = $_POST['password'] ?? '';
  // $nickname = trim($_POST['nickname'] ?? '');
  // $department = trim($_POST['department'] ?? '');
  // $languages_spoken = trim($_POST['languages_spoken'] ?? '');
  // $hobbies = trim($_POST['hobbies'] ?? '');
  // $self_intro = trim($_POST['self_intro'] ?? '');
  // $country= trim($_POST['country'] ?? '');
  // $gender= trim($_POST['gender'] ?? '');

  // if (!$username || !$password) {
  //     $error = "Username and password are required.";
  // } else {
  //     $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
  //     $stmt->execute([$username]);
  //     if ($stmt->fetch()) {
  //         $error = "Username already taken.";
  //     } else {
  //         $picturePath = null;
  //         if (!empty($_FILES['picture']['name'])) {
  //             $targetDir = "uploads/";
  //             if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

  //             $fileName = basename($_FILES["picture"]["name"]);
  //             $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  //             $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

  //             if (!in_array($fileType, $allowedTypes)) {
  //                 $error = "Only JPG, JPEG, PNG & GIF files allowed.";
  //             } else {
  //                 $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9_\.-]/", '_', $fileName);
  //                 $targetFilePath = $targetDir . $newFileName;
  //                 if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $targetFilePath)) {
  //                     $error = "Error uploading picture.";
  //                 } else {
  //                     $picturePath = $targetFilePath;
  //                 }
  //             }
  //         }

  //         if (!$error) {
  //             $passwordHash = password_hash($password, PASSWORD_DEFAULT);
  //             $stmt = $pdo->prepare("INSERT INTO users 
  //                 (username, password, nickname, department, languages_spoken, hobbies, self_intro, picture) 
  //                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  //             $stmt->execute([
  //                 $username, $passwordHash, $nickname, $department, 
  //                 $languages_spoken, $hobbies, $self_intro, $picturePath
  //             ]);
  //             header("Location: login.php?registered=1");
  //             exit;
  //         }
  //     }
  // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up - iConnect</title>
  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/signup.css" />
</head>

<body>
  <?php include 'components/header.php'; ?>

  <div class="signup-container">
    <form method="POST" action="signup.php" enctype="multipart/form-data" novalidate>
      <h2>Create Your Account</h2>

      <?php if ($error): ?>
        <div class="message"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <label for="username">Username *</label>
      <input type="text" id="username" name="username" required value="<?= htmlspecialchars($username) ?>" autocomplete="username" />

      <label for="password">Password *</label>
      <input type="password" id="password" name="password" required autocomplete="new-password" />

      <label for="nickname">Nickname</label>
      <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($nickname) ?>" />

      <label for="department">Department</label>
      <input type="text" id="department" name="department" value="<?= htmlspecialchars($department) ?>" />

      <label for="languages_spoken">Languages Spoken</label>
      <input type="text" id="languages_spoken" name="languages_spoken" value="<?= htmlspecialchars($languages_spoken) ?>" placeholder="e.g. English, Japanese" />

      <label for="hobbies">Hobbies</label>
      <input type="text" id="hobbies" name="hobbies" value="<?= htmlspecialchars($hobbies) ?>" placeholder="e.g. Reading, Hiking" />

      <label for="self_intro">Self Introduction</label>
      <textarea id="self_intro" name="self_intro" placeholder="Tell us about yourself..."><?= htmlspecialchars($self_intro) ?></textarea>

      <label for="picture">Profile Picture</label>
      <input type="file" id="picture" name="picture" accept="image/*" />

      <img id="picture-preview" src="#" alt="Profile picture preview" style="display:none;" />

      <button type="submit">Register</button>

      <div class="back-link">
        <a href="index.php">← Back to Welcome Page</a>
      </div>
    </form>
  </div>

  <script>
    const pictureInput = document.getElementById('picture');
    const previewImg = document.getElementById('picture-preview');

    pictureInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImg.src = e.target.result;
          previewImg.style.display = 'block';
        }
        reader.readAsDataURL(file);
      } else {
        previewImg.src = '#';
        previewImg.style.display = 'none';
      }
    });
  </script>

</body>

</html>
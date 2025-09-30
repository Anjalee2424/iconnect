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
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #f7f5ff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
    }
    form {
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(124, 77, 255, 0.15);
      width: 400px;
      padding: 30px 40px;
      box-sizing: border-box;
    }
    h2 {
      margin: 0 0 25px;
      color: #7c4dff;
      font-weight: 600;
      text-align: center;
      font-size: 28px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: #555;
      margin-top: 15px;
    }
    input[type="text"],
    input[type="password"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px 12px;
      border: 1.8px solid #ddd;
      border-radius: 8px;
      font-size: 15px;
      transition: border-color 0.3s ease;
      box-sizing: border-box;
    }
    input[type="text"]:focus,
    input[type="password"]:focus,
    textarea:focus,
    input[type="file"]:focus {
      outline: none;
      border-color: #7c4dff;
      box-shadow: 0 0 8px rgba(124, 77, 255, 0.3);
    }
    textarea {
      resize: vertical;
      min-height: 60px;
      font-family: 'Inter', sans-serif;
    }
    button {
      margin-top: 25px;
      width: 100%;
      padding: 14px;
      border: none;
      border-radius: 10px;
      background-color: #7c4dff;
      color: white;
      font-weight: 600;
      font-size: 17px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 14px rgba(124, 77, 255, 0.4);
    }
    button:hover {
      background-color: #653bcc;
      box-shadow: 0 6px 20px rgba(101, 59, 204, 0.6);
    }
    .message {
      margin-top: 15px;
      color: red;
      font-weight: 600;
      text-align: center;
    }
    .back-link {
      margin-top: 20px;
      text-align: center;
      font-size: 14px;
    }
    .back-link a {
      color: #7c4dff;
      text-decoration: none;
      font-weight: 600;
    }
    .back-link a:hover {
      text-decoration: underline;
    }

    /* Profile picture preview styles */
    #picture-preview {
      display: block;
      margin: 12px auto 0;
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #7c4dff;
      box-shadow: 0 0 10px rgba(124, 77, 255, 0.4);
      transition: opacity 0.3s ease;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <form method="POST" action="signup.php" enctype="multipart/form-data" novalidate>
    <h2>Create Your Account</h2>

    <?php if ($error): ?>
      <div class="message"><?=htmlspecialchars($error)?></div>
    <?php endif; ?>

    <label for="username">Username *</label>
    <input type="text" id="username" name="username" required value="<?=htmlspecialchars($username)?>" autocomplete="username" />

    <label for="password">Password *</label>
    <input type="password" id="password" name="password" required autocomplete="new-password" />

    <label for="nickname">Nickname</label>
    <input type="text" id="nickname" name="nickname" value="<?=htmlspecialchars($nickname)?>" />

    <label for="department">Department</label>
    <input type="text" id="department" name="department" value="<?=htmlspecialchars($department)?>" />

    <label for="languages_spoken">Languages Spoken</label>
    <input type="text" id="languages_spoken" name="languages_spoken" value="<?=htmlspecialchars($languages_spoken)?>" placeholder="e.g. English, Japanese" />

    <label for="hobbies">Hobbies</label>
    <input type="text" id="hobbies" name="hobbies" value="<?=htmlspecialchars($hobbies)?>" placeholder="e.g. Reading, Hiking" />

    <label for="self_intro">Self Introduction</label>
    <textarea id="self_intro" name="self_intro" placeholder="Tell us about yourself..."><?=htmlspecialchars($self_intro)?></textarea>

    <label for="picture">Profile Picture</label>
    <input type="file" id="picture" name="picture" accept="image/*" />

    <img id="picture-preview" src="#" alt="Profile picture preview" style="display:none;" />

    <button type="submit">Register</button>

    <div class="back-link">
      <a href="index.php">← Back to Welcome Page</a>
    </div>
  </form>

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

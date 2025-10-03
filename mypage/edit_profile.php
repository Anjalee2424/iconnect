<?php
$user = [
    'username' => 'javacash',
    'email' => 'javacash@example.com',
    'nickname' => 'Javacash Ağa',
    'password' => '',
    'self_intro' => 'Here to connect with the world! I\'m learning Chinese mostly, but also Farsi Hindi.',
    'department' => 'Language Learning',
    'languages' => ['English','Chinese','Farsi'],
    'interests' => ['Fashion','Netflix','Traveling'],
    'profile_pic' => 'user-avatar.jpg'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user['username'] = $_POST['username'] ?? $user['username'];
    $user['email'] = $_POST['email'] ?? $user['email'];
    $user['nickname'] = $_POST['nickname'] ?? $user['nickname'];
    $user['password'] = $_POST['password'] ?? $user['password'];
    $user['self_intro'] = $_POST['self_intro'] ?? $user['self_intro'];
    $user['department'] = $_POST['department'] ?? $user['department'];

    $user['languages'] = explode(',', $_POST['languages'] ?? implode(',', $user['languages']));
    $user['interests'] = explode(',', $_POST['interests'] ?? implode(',', $user['interests']));

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
        $filename = $uploadDir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filename);
        $user['profile_pic'] = $filename;
    }

    $success = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile - iConnect</title>
<style>
/* Global */
body { font-family: 'Poppins', Arial, sans-serif; background: #f5f2ff; margin:0; padding:0; }
.container { max-width: 700px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 20px; box-shadow: 0 10px 25px rgba(124,77,255,0.2); }
h2 { text-align: center; margin-bottom: 25px; color:#5b2df4; }

/* Success Message */
.success { background: #f0e6ff; color: #5b2df4; padding: 12px; border-radius: 10px; margin-bottom: 15px; text-align:center; font-weight:600; }

/* Form */
form { display:flex; flex-direction:column; gap:15px; }
label { font-weight:600; color:#4a2bb7; margin-bottom:5px; }
input[type=text], input[type=email], input[type=password], textarea { padding:10px; border-radius:12px; border:1px solid #dcd6f7; width:100%; outline:none; transition: 0.3s; }
input[type=text]:focus, input[type=email]:focus, input[type=password]:focus, textarea:focus { border-color:#7c4dff; box-shadow:0 0 10px rgba(124,77,255,0.2); }
textarea { resize:vertical; }
input[type=file] { padding:5px; border:none; }

/* Button */
button { padding:12px; border:none; border-radius:25px; background: linear-gradient(135deg,#7c4dff,#c47dff); color:#fff; font-size:16px; cursor:pointer; transition:0.3s; font-weight:600; }
button:hover { background: linear-gradient(135deg,#5b2df4,#9c4dff); }

/* Profile Pic */
.profile-pic-preview { width:100px; height:100px; border-radius:50%; object-fit:cover; margin-bottom:10px; border: 3px solid #7c4dff; }

/* Tags Input */
.tags-container { display:flex; flex-wrap:wrap; gap:8px; border:1px solid #dcd6f7; padding:8px; border-radius:12px; cursor:text; }
.tags-container span { background: linear-gradient(135deg,#7c4dff,#c47dff); color:#fff; padding:5px 10px; border-radius:15px; display:flex; align-items:center; gap:5px; }
.tags-container span .remove { cursor:pointer; font-weight:bold; }
.tags-container input { border:none; outline:none; flex:1; min-width:120px; padding:5px; }

/* Responsive */
@media (max-width:600px){
    .container { margin:20px; padding:20px; }
    .profile-pic-preview { width:80px; height:80px; }
}
</style>
</head>
<body>
<div class="container">
<h2>Edit Profile</h2>

<?php if(isset($success)) echo "<div class='success'>{$success}</div>"; ?>

<form action="" method="POST" enctype="multipart/form-data">
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
    <div><label>Department</label><input type="text" name="department" value="<?php echo htmlspecialchars($user['department']); ?>"></div>

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

<script>
// Image preview
function previewImage(event){
    const preview = document.getElementById('profilePreview');
    preview.src = URL.createObjectURL(event.target.files[0]);
}

// Tag logic
function setupTags(containerId, hiddenInputId, initialTags){
    const container = document.getElementById(containerId);
    const hiddenInput = document.getElementById(hiddenInputId);
    let tags = initialTags.slice();

    function update(){
        container.innerHTML = '';
        tags.forEach((tag,i)=>{
            const span = document.createElement('span');
            span.textContent = tag;
            const remove = document.createElement('span');
            remove.textContent = '×';
            remove.className = 'remove';
            remove.onclick = ()=>{tags.splice(i,1);update();}
            span.appendChild(remove);
            container.appendChild(span);
        });
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Add...';
        input.onkeydown = (e)=>{
            if(e.key==='Enter' && input.value.trim()!==''){
                e.preventDefault();
                tags.push(input.value.trim());
                input.value='';
                update();
            }
        };
        container.appendChild(input);
        hiddenInput.value = tags.join(',');
    }
    update();
}

setupTags('languagesContainer','languagesInput', <?php echo json_encode($user['languages']); ?>);
setupTags('interestsContainer','interestsInput', <?php echo json_encode($user['interests']); ?>);
</script>
</body>
</html>

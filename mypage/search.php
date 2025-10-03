<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$users = [
    [
        'name' => 'Javacash Ağa',
        'image' => 'user-avatar.jpg',
        'bio' => 'Learning Chinese mostly, love travel and fashion.',
        'tags' => ['serious-learners', 'travel', 'fashion']
    ],
    [
        'name' => 'Rahul',
        'image' => 'user-avatar2.jpg',
        'bio' => 'I speak English and learning Farsi. Open to making new friends.',
        'tags' => ['nearby', 'new']
    ],
    [
        'name' => 'Jay',
        'image' => 'user-avatar3.jpg',
        'bio' => 'Goal: Communicate effectively in foreign languages.',
        'tags' => ['city', 'free-to-chat', 'new']
    ],
    [
        'name' => 'Atish Panda',
        'image' => 'user-avatar4.jpg',
        'bio' => 'Hi Folks',
        'tags' => ['connect', 'vip', 'english']
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Find Partners</title>
<style>
/* ====== Global Styling ====== */
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 50px 20px;
    background: linear-gradient(270deg, #7c4dff, #9c4dff, #c47dff, #7c4dff);
    background-size: 800% 800%;
    animation: gradientFlow 18s ease infinite;
    color: #fff;
}

/* Smooth animated background */
@keyframes gradientFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.container {
    max-width: 1200px;
    width: 100%;
}

/* ====== Heading ====== */
h1 {
    text-align: center;
    font-size: 3rem;
    margin-bottom: 40px;
    letter-spacing: 1px;
    text-transform: uppercase;
    background: linear-gradient(90deg, #fff, #ffd6ff, #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: glowPulse 3s infinite alternate;
}

@keyframes glowPulse {
    from { text-shadow: 0 0 10px rgba(255,255,255,0.4); }
    to { text-shadow: 0 0 25px rgba(255,255,255,0.9); }
}

/* ====== Filter Buttons ====== */
.filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 50px;
}

.filters button {
    padding: 12px 30px;
    border-radius: 30px;
    border: none;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(8px);
    color: #fff;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 0 10px rgba(196,125,255,0.3);
}

.filters button.active,
.filters button:hover {
    background: linear-gradient(45deg, #7c4dff, #c47dff);
    box-shadow: 0 0 20px rgba(196,125,255,0.8);
}

/* ====== Profiles Grid ====== */
.user-profiles {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

/* ====== Profile Card (Glassmorphism) ====== */
.profile {
    display: flex;
    padding: 25px;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    border-radius: 25px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.25);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    animation: floaty 6s ease-in-out infinite;
}

@keyframes floaty {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.profile:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 40px rgba(124, 77, 255, 0.5);
}

.profile img {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 20px;
    flex-shrink: 0;
    border: 3px solid transparent;
    background: linear-gradient(45deg, #7c4dff, #c47dff) border-box;
    box-shadow: 0 0 20px rgba(124,77,255,0.6);
    transition: transform 0.3s ease;
}

.profile img:hover {
    transform: rotate(5deg) scale(1.1);
}

.profile-info h3 {
    margin: 0 0 8px 0;
    font-size: 1.4rem;
    color: #fff;
    text-shadow: 0 0 6px rgba(124,77,255,0.8);
}

.profile-info p {
    font-size: 14px;
    color: #eee;
    margin-bottom: 12px;
}

/* ====== Tags ====== */
.tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tags span {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #fff;
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.3);
    box-shadow: 0 0 8px rgba(196,125,255,0.6);
}

/* ====== Connect Button ====== */
.connect-btn {
    margin-top: 15px;
    padding: 12px 25px;
    background: linear-gradient(45deg, #7c4dff, #c47dff);
    color: #fff;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 0 15px rgba(196,125,255,0.6);
}

.connect-btn:hover {
    background: linear-gradient(45deg, #c47dff, #7c4dff);
    box-shadow: 0 0 30px rgba(196,125,255,1);
    transform: translateY(-3px);
}

/* Responsive */
@media (max-width:600px) {
    .profile {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile img {
        margin: 0 0 15px 0;
    }

    .connect-btn {
        width: 100%;
    }
}
</style>
</head>
<body>
<div class="container">
    <h1>Find Partners</h1>

    <div class="filters">
        <button class="active" data-filter="all">All</button>
        <button data-filter="serious-learners">Serious Learners</button>
        <button data-filter="nearby">Nearby</button>
        <button data-filter="city">City</button>
    </div>

    <div class="user-profiles">
        <?php foreach ($users as $user): ?>
        <form action="friends/add.php" method="post">
            <div class="profile" data-tags="<?php echo implode(' ', $user['tags']); ?>">
                <img src="<?php echo $user['image']; ?>" alt="<?php echo $user['name']; ?>">
                <div class="profile-info">
                    <h3><?php echo $user['name']; ?></h3>
                    <p><?php echo $user['bio']; ?></p>
                    <div class="tags">
                        <?php foreach ($user['tags'] as $tag): ?>
                            <span><?php echo ucfirst($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <button class="connect-btn">Connect</button>
                </div>
            </div>
        </form>
        <?php endforeach; ?>
    </div>
</div>

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

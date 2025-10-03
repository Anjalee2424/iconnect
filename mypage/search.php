<?php
// Enable error reporting (optional)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sample users data
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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f0f2f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        /* Filter buttons */
        .filters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 40px;
        }

        .filters button {
            padding: 10px 20px;
            border-radius: 25px;
            border: 1px solid #ccc;
            background-color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filters button.active,
        .filters button:hover {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        /* Profiles grid */
        .user-profiles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        /* Profile card */
        .profile {
            display: flex;
            align-items: flex-start;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s, opacity 0.3s;
            opacity: 1;
        }

        .profile.hide {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        .profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .profile-info {
            flex: 1;
        }

        .profile-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .profile-info p {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tags span {
            background-color: #f0f0f0;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            color: #555;
        }

        .connect-btn {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 13px;
            transition: background-color 0.3s;
        }

        .connect-btn:hover {
            background-color: #218838;
        }

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

        <!-- Filter buttons -->
        <div class="filters">
            <button class="active" data-filter="all">All</button>
            <button data-filter="serious-learners">Serious Learners</button>
            <button data-filter="nearby">Nearby</button>
            <button data-filter="city">City</button>
        </div>

        <!-- Profiles grid -->
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
                </form>
        </div>
    <?php endforeach; ?>
    </div>
    </div>

    <script>
        // Filter functionality
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
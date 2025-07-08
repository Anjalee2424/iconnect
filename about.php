<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$lang = $_GET['lang'] ?? 'en';

if ($lang === 'ja') {
  $title = 'iConnectについて';
  $intro = 'iConnectは、YSE専門学校の学生のために開発された多言語コミュニケーションプラットフォームです。異なる文化や言語背景を持つ学生同士が簡単につながり、コミュニケーションできるようにします。';
  $features_title = '機能:';
  $features = [
    'プロフィール作成と閲覧',
    '言語交換サポート',
    'テキスト、音声、ビデオチャット',
    '翻訳とフレーズブックツール',
    'イベント共有と参加',
    '安全機能（通報/ブロック）'
  ];
  $goal = 'すべての学生が歓迎され、つながりを感じられる空間を作ることが私たちの目標です。';
} else {
  $title = 'About iConnect';
  $intro = 'iConnect is a multilingual communication platform developed for students of YSE College. It enables easy connection and communication between students from different cultural and language backgrounds.';
  $features_title = 'Features:';
  $features = [
    'Profile creation and browsing',
    'Language exchange support',
    'Text, audio, and video chat',
    'Translation and phrasebook tools',
    'Event sharing and participation',
    'Safety tools (report/block)'
  ];
  $goal = 'Our goal is to create a space where every student feels welcome and connected.';
}
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?></title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9ff;
      color: #333;
    }

    .header {
      background-color: #4d44f6;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo a {
      font-size: 1.8em;
      font-weight: bold;
      color: white;
      text-decoration: none;
    }

    .nav a {
      color: white;
      margin-right: 15px;
      text-decoration: none;
    }

    .nav select {
      padding: 5px;
      border-radius: 4px;
    }

    .main-content {
      padding: 40px 20px;
      max-width: 1000px;
      margin: auto;
    }

    .about {
      text-align: center;
    }

    h1 {
      color: #4d44f6;
    }

    ul {
      list-style: none;
      padding: 0;
      text-align: left;
      max-width: 600px;
      margin: 20px auto;
    }

    ul li {
      background-color: #eae8ff;
      margin: 10px 0;
      padding: 12px 20px;
      border-radius: 10px;
    }

    .about img {
      width: 80%;
      max-width: 600px;
      border-radius: 15px;
      margin-top: 30px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .footer {
      background-color: #4d44f6;
      color: white;
      text-align: center;
      padding: 15px 0;
      margin-top: 50px;
    }

    @media (max-width: 600px) {
      .header, .nav {
        flex-direction: column;
        align-items: flex-start;
      }

      .nav a {
        margin: 10px 0;
      }
    }
  </style>
</head>
<body>
  <header class="header">
    <div class="logo"><a href="index.html">iConnect</a></div>
    <nav class="nav">
      <a href="index.html">Home</a>
      <a href="#">Web Version</a>
      <select onchange="location = '?lang=' + this.value;">
        <option value="en" <?= $lang === 'en' ? 'selected' : '' ?>>English</option>
        <option value="ja" <?= $lang === 'ja' ? 'selected' : '' ?>>日本語</option>
      </select>
    </nav>
  </header>

  <main class="main-content">
    <section class="about">
      <h1><?= $title ?></h1>
      <p><?= $intro ?></p>

      <h2><?= $features_title ?></h2>
      <ul>
        <?php foreach ($features as $item): ?>
          <li><?= $item ?></li>
        <?php endforeach; ?>
      </ul>

      <p><?= $goal ?></p>

      <!-- Replace with your own image if needed -->
      <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=1200&q=80" alt="Students communicating" />
    </section>
  </main>

  <footer class="footer">
    <p>&copy; 2025 iConnect - All rights reserved.</p>
  </footer>
</body>
</html>

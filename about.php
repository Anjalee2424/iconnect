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
  <link rel="stylesheet" href="css/default.css" />
  <link rel="stylesheet" href="css/about.css" />
</head>
<body>
  <?php include 'components/header.php'; ?>

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

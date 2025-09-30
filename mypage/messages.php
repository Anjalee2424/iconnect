<?php
$filename = "messages.txt";

if (!file_exists($filename)) {
    file_put_contents($filename, ""); // create file if it doesn't exist
}

$messages = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($messages as $message) {
    // Simple way to differentiate sent and received
    // For demonstration, alternate messages as sent/received
    static $i = 0;
    $class = ($i % 2 === 0) ? 'sent' : 'received';
    echo '<div class="message ' . $class . '">' . htmlspecialchars($message) . '</div>';
    $i++;
}
?>


<?php
$filename = "messages.txt";

// If new message is posted
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["message"])) {
    $msg = htmlspecialchars($_POST["message"]);
    file_put_contents($filename, $msg . "\n", FILE_APPEND);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat UI</title>
    <link rel="stylesheet" href="../css/chat.css">
</head>

<body>
    <div class="chat-container">
        <div class="chat-header">
            <h3>Roberto Martinez</h3>
            <span>Active 2m ago</span>
        </div>

        <!-- Messages -->
        <div class="chat-messages" id="chat-box"></div>

        <!-- Input -->
        <div class="chat-input">
            <input type="text" id="msg" placeholder="Type a message">
            <button onclick="sendMessage()">➤</button>
        </div>
    </div>

    <?php include '../components/user_menu.php'; ?>

    <script>
        function loadMessages() {
            fetch("messages.php")
                .then(res => res.text())
                .then(data => {
                    document.getElementById("chat-box").innerHTML = data;
                    let box = document.getElementById("chat-box");
                    box.scrollTop = box.scrollHeight;
                });
        }

        function sendMessage() {
            let msg = document.getElementById("msg").value;
            if (msg.trim() === "") return;

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "chat.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("message=" + encodeURIComponent(msg));

            document.getElementById("msg").value = "";
            setTimeout(loadMessages, 300); // reload after send
        }

        // Refresh every 2 seconds
        setInterval(loadMessages, 2000);
        window.onload = loadMessages;
    </script>
</body>

</html>
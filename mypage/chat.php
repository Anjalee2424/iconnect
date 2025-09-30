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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat-container {
            width: 400px;
            max-width: 100%;
            height: 600px;
            background: #fff;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #fff;
        }

        .chat-header h3 {
            margin: 0;
            font-size: 16px;
        }

        .chat-header span {
            font-size: 12px;
            color: gray;
        }

        .chat-messages {
            flex: 1;
            padding: 15px;
            overflow-y: auto;
            background: #fafafa;
            display: flex;
            flex-direction: column;
        }

        .message {
            margin: 10px 0;
            max-width: 75%;
            padding: 10px 15px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .sent {
            background: linear-gradient(135deg, #7c4dff, #c47dff, #fcaee4);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
        }

        .received {
            background: #f1f0f0;
            color: black;
            align-self: flex-start;
            border-bottom-left-radius: 4px;
        }

        .chat-input {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #eee;
            background: #fff;
        }

        .chat-input input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ccc;
            outline: none;
        }

        .chat-input button {
            background: #7c4dff;
            border: none;
            color: white;
            margin-left: 10px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
    </style>
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
// ================================
// 環境チェック
// ================================
console.log("ROOM_ID:", ROOM_ID);
console.log("USER_NICKNAME:", USER_NICKNAME);
if (typeof ROOM_ID === "undefined" || ROOM_ID === "") {
    alert("ROOM_IDが設定されていません");
}


const userName = USER_NICKNAME;
const roomId = ROOM_ID;
let chat_host = (typeof CHAT_HOST !== "undefined") 
                ? CHAT_HOST 
                : window.location.protocol + "//" + window.location.host;

// chat_path: サブディレクトリパスを自動設定
let chat_path = (typeof CHAT_PATH !== "undefined") 
                ? CHAT_PATH 
                : "/chat_server"; 

// ================================
// DOM要素取得
// ================================
const form = document.getElementById("chatForm");
const input = document.getElementById("msgInput");
const chatBox = document.getElementById("chat-box");
const langSelect = document.getElementById("langSelect");
const sendBtn = document.getElementById("sendBtn");
const micBtn = document.getElementById("micBtn");

// ================================
// サーバー接続
// ================================
// const socket = io(CHAT_HOST, { transports: ["websocket"] });
const socket = io(
    chat_host,
    {
        transports: ["websocket"],
        path: `${chat_path}/socket.io`
    });

// 接続時
socket.on("connect", () => {
    console.log("🟢 Connected:", socket.id);
    socket.name = userName;
    socket.emit("join_room", { roomId, userName, userId });
    append(`🟢 ${userName} joined the chat`, "system message");
});


// ================================
// 参加者リスト更新
// ================================
socket.on("user_list", (users) => {
    console.log("現在の参加者:", users);
    renderUserList(users);
});

function renderUserList(users) {
    const listElement = document.getElementById("userList");
    listElement.innerHTML = users.map(u => 
        `
        <li class="flex items-center mb-2">
            <img src="${u.avatarUrl || '../uploads/users/' + u.id + '.jpg'}" alt="avatar" class="inline-block w-6 h-6 rounded-full mr-2 align-middle">
            <span class="align-middle mr-2 ${u.id === userId ? 'font-bold' : ''}">${u.nickname}</span>
        </li>
        `
    ).join("");
}

// ================================
// メッセージ受信
// ================================
socket.on("chat_message", async (data) => {
    const { text, sender, lang: fromLang } = data;

    // 通常メッセージを表示
    append(`${sender}: ${text}`, "message received", fromLang);

    if (sender === userName) return; // 自分のメッセージは翻訳不要

    const toLang = langSelect.value;
    if (fromLang === toLang) return; // 同じ言語なら翻訳不要

    // ★変更点1: 翻訳中メッセージを表示し、その要素を変数に保存
    // CSSクラス 'translating-pulse' を適用
    const loadingElement = append(`🔵 翻訳中...`, "translating-pulse");

    try {
        const uri = `${API_HOST}/api/translate`;
        console.log("Translation API URI:", uri);
        const res = await fetch(uri, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ text, fromLang, toLang }),
        });
        const result = await res.json();

        // ★変更点2: API応答が帰ってきたら、翻訳中メッセージを削除
        if (loadingElement) loadingElement.remove();

        if (result.translatedText) {
            append(`🌍 ${sender}: ${result.translatedText}`);
        } else {
            append("⚠️ 翻訳に失敗しました");
        }
    } catch (err) {
        console.error("Translation API error:", err);
        // エラー時も翻訳中メッセージを削除
        if (loadingElement) loadingElement.remove();
        append("⚠️ 翻訳に失敗しました（ネットワークエラー）");
    }
});

// ================================
// メッセージ送信
// ================================
form.addEventListener("submit", (e) => {
    // 変換中のEnterキーなら、送信処理をスキップする
    if (isComposing) {
        e.preventDefault();
        return;
    }

    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;

    append(text, "message sent justify-end");

    const lang = langSelect.value;
    socket.emit("send_message", { text, roomId, sender: userName, lang });
    input.value = "";
});

// ================================
// 表示関数
// ================================
function append(msg, className = "", langCode = null) {
    const div = document.createElement("div");
    div.className = `flex items-center space-x-2 ${className}`;

    // メッセージ本文の作成
    const span = document.createElement("span");
    span.innerHTML = msg;
    div.appendChild(span);

    // 翻訳中やシステムメッセージ以外で、かつ言語コードがある場合にアイコンを表示
    if (langCode && !className.includes("system")) {
        const speakBtn = document.createElement("button");
        speakBtn.innerHTML = "🔊";
        speakBtn.className = "text-blue-500 hover:scale-110 transition-transform ml-2";
        
        // テキスト抽出（名前部分を除去して純粋なメッセージのみを渡す）
        const cleanText = msg.includes(":") ? msg.split(":").slice(1).join(":").trim() : msg;
        
        speakBtn.onclick = () => speak(cleanText, langCode, speakBtn);
        div.appendChild(speakBtn);
    }

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
    return div;
}

// ================================
// 🎙️ STT（音声入力）モジュール
// ================================
const STT = {
    recognition: null,
    isListening: false,
    onText: null,
    onEnd: null,

    init(lang) {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        if (!SpeechRecognition) {
            console.warn("ブラウザが音声認識に対応していません（Chrome推奨）");
            return;
        }

        console.log("STT initialized with lang:", lang);
        this.recognition = new SpeechRecognition();
        this.recognition.lang = lang;
        this.recognition.interimResults = true;
        this.recognition.continuous = false;

        this.recognition.onresult = (event) => {
            const text = event.results[0][0].transcript;
            if (this.onText) this.onText(text);
        };

        this.recognition.onend = () => {
            this.isListening = false;
            if (this.onEnd) this.onEnd();
        };
    },

    start() { if (!this.recognition) return; this.isListening = true; this.recognition.start(); },
    stop() { if (!this.recognition) return; this.recognition.stop(); this.isListening = false; }
};

// デフォルト日本語で初期化
STT.init("ja-JP");

// 音声認識結果を入力欄に反映
STT.onText = (text) => { input.value = text; };

// 音声認識終了時
STT.onEnd = () => { micBtn.textContent = "🎤"; };

input.addEventListener("focus", () => {
    if (STT.isListening) {
        STT.stop();
        micBtn.textContent = "🎤";
    }
});

// マイクボタンで STT 開始/停止
// マイクボタン内の修正
micBtn.addEventListener("click", () => {
    if (!STT.isListening) {
        const selectedOption = langSelect.selectedOptions[0];
        
        // 修正：dataset.lang が無ければ value を、それも無ければ 'ja-JP' を使う
        const langCode = selectedOption?.dataset.lang || selectedOption?.value || "ja-JP";
        
        console.log("STT starting with lang:", langCode); // 確認用

        if (STT.recognition) STT.stop();
        STT.init(langCode);
        STT.start();
        micBtn.textContent = "🎙️ 受付中...";
    } else {
        STT.stop();
        micBtn.textContent = "🎤";
    }
});

// 言語変更時にも STT 言語更新（マイク未押下時）
langSelect.addEventListener("change", () => {
    const selectedOption = langSelect.selectedOptions[0];
    const langCode = selectedOption?.dataset.lang;
    if (STT.recognition) STT.stop();
    STT.init(langCode);
    console.log("STT language set to:", langCode);
    if (!STT.isListening) micBtn.textContent = "🎤";
});


// ================================
// IME変換状態の管理
// ================================
let isComposing = false; // 変換中フラグ

input.addEventListener('compositionstart', () => {
    isComposing = true;
});

input.addEventListener('compositionend', () => {
    isComposing = false;
});


const speak = async (text, lang, btn) => {
    // Express API 経由で音声合成を実行
    try {
        // ボタンを無効化
        btn.disabled = true;
        btn.style = "opacity: 0.5;";

        const uri = `${API_HOST}/api/tts`;
        console.log("TTS API URI:", uri);
        const res = await fetch(uri, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ text, lang }),
        });
        // ファイルパスを取得
        const result = await res.json();
        console.log("TTS API result:", result);
        if (result.audioUrl) {
            const audio = new Audio(result.audioUrl);
            audio.play();
        } else {
            append("⚠️ 音声合成に失敗しました");
        }
    } catch (err) {
        console.error("TTS API error:", err);
        // エラー時も翻訳中メッセージを削除
        if (loadingElement) loadingElement.remove();
        append("⚠️ 音声合成に失敗しました（ネットワークエラー）");
    } finally {
        // ボタンを再有効化
        btn.disabled = false;
        btn.style = "opacity: 1;";
    }
}
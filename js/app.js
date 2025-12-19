// ================================
// 環境チェック
// ================================
if (typeof ROOM_ID === "undefined" || ROOM_ID === "") {
    alert("ROOM_IDが設定されていません");
}

if (typeof USER_NAME === "undefined" || USER_NAME === "") {
    alert("USER_NAMEが設定されていません");
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

// ============== 修正箇所 ここまで ==============

// document.getElementById("host").textContent = chat_host;
// document.getElementById("path").textContent = chat_path;
// document.getElementById("room_id").textContent = ROOM_ID;

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
    socket.emit("join_room", { roomId, userName });
    append(`🟢 ${userName} joined the chat`, "system message");
});

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
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;

    append(text, "message sent");

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
        
        speakBtn.onclick = () => speak(cleanText, langCode);
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

// マイクボタンで STT 開始/停止
micBtn.addEventListener("click", () => {
    if (!STT.isListening) {
        // 選択中の option の data-lang を取得
        const selectedOption = langSelect.selectedOptions[0];
        const langCode = selectedOption?.dataset.lang;
        console.log("STT initialized with lang:", langCode);

        // 古いインスタンス停止
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


const speak = async (text, lang) => {
    // Express API 経由で音声合成を実行
    try {
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
    }
}
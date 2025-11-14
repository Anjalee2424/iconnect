// ==============================
// ① 言語データ
// ==============================
const langs = {
    ja: { lang: "ja-JP", label: "Japanese - 日本語", voice: "bqpOyYNUu11tjjvRUbKn" },
    en: { lang: "en-US", label: "English - 英語", voice: "21m00Tcm4TlvDq8ikWAM" },
    es: { lang: "es-ES", label: "Español - スペイン語", voice: "21m00Tcm4TlvDq8ikWAM" },
    de: { lang: "de-DE", label: "Deutsch - ドイツ語", voice: "21m00Tcm4TlvDq8ikWAM" },
    fr: { lang: "fr-FR", label: "Français - フランス語", voice: "kwhMCf63M8O3rCfnQ3oQ" },
    bn: { lang: "bn-BD", label: "বাংলা - ベンガル語", voice: "WiaIVvI1gDL4vT4y7qUU" },
    zh: { lang: "zh-CN", label: "中文 - 中国語", voice: "21m00Tcm4TlvDq8ikWAM" },
    vi: { lang: "vi-VN", label: "Tiếng Việt - ベトナム語", voice: "21m00Tcm4TlvDq8ikWAM" },
    si: { lang: "si-LK", label: "සිංහල - シンハラ語", voice: "21m00Tcm4TlvDq8ikWAM" },
    id: { lang: "id-ID", label: "Bahasa Indonesia - インドネシア語", voice: "4h05pJAlcSqTMs5KRd8X" },
    ne: { lang: "ne-NP", label: "नेपाली - ネパール語", voice: "21m00Tcm4TlvDq8ikWAM" },
    mn: { lang: "mn-MN", label: "Монгол - モンゴル語", voice: "21m00Tcm4TlvDq8ikWAM" },
    my: { lang: "my-MM", label: "မြန်မာ - ミャンマー語", voice: "21m00Tcm4TlvDq8kWAM" }
};

// ==============================
// ② 初期値を hidden input から JS で復元
// ==============================

// Languages Spoken
let languagesTags = document.getElementById('languagesInput').value
    ? document.getElementById('languagesInput').value.split(',')
    : [];

// Interests (従来の機能)
let interestsTags = document.getElementById('interestsInput').value
    ? document.getElementById('interestsInput').value.split(',')
    : [];


// ==============================
// ③ 言語追加ボタン
// ==============================
function addLanguage() {
    const select = document.getElementById('langSelect');
    const value = select.value;

    if (!value) return;

    if (languagesTags.includes(value)) {
        alert("Already added.");
        return;
    }

    languagesTags.push(value);
    setupTags('languagesContainer', 'languagesInput', languagesTags);
}

// ==============================
// ④ プロフィール画像プレビュー
// ==============================
function previewImage(event) {
    const preview = document.getElementById('profilePreview');
    preview.src = URL.createObjectURL(event.target.files[0]);
}

// ==============================
// ⑤ タグ管理UI（共通）
// ==============================
function setupTags(containerId, hiddenInputId, tags) {
    const container = document.getElementById(containerId);
    const hiddenInput = document.getElementById(hiddenInputId);

    function update() {
        container.innerHTML = '';

        // タグ生成
        tags.forEach((tag, i) => {
            const span = document.createElement('span');
            span.textContent = tag;

            const remove = document.createElement('span');
            remove.textContent = '×';
            remove.className = 'remove';
            remove.onclick = () => {
                tags.splice(i, 1);
                update();
            };

            span.appendChild(remove);
            container.appendChild(span);
        });

        // 手入力追加欄
        const input = document.createElement('input');
        input.type = 'text';
        input.placeholder = 'Add...';
        input.onkeydown = (e) => {
            if (e.key === 'Enter' && input.value.trim() !== '') {
                e.preventDefault();
                tags.push(input.value.trim());
                input.value = '';
                update();
            }
        };

        container.appendChild(input);

        // hidden input 更新
        hiddenInput.value = tags.join(',');
    }

    update();
}


// ==============================
// ⑥ ページロード時にタグを復元
// ==============================
setupTags('languagesContainer', 'languagesInput', languagesTags);
setupTags('interestsContainer', 'interestsInput', interestsTags);
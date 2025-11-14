<?php

class Lang
{
    const langs = [
        'ja' => [
            'lang'  => "ja-JP",
            'label' => "Japanese - 日本語",
            'voice' => "bqpOyYNUu11tjjvRUbKn"
        ],
        'en' => [
            'lang'  => "en-US",
            'label' => "English - 英語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'es' => [
            'lang'  => "es-ES",
            'label' => "Español - スペイン語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'de' => [
            'lang'  => "de-DE",
            'label' => "Deutsch - ドイツ語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'fr' => [
            'lang'  => "fr-FR",
            'label' => "Français - フランス語",
            'voice' => "kwhMCf63M8O3rCfnQ3oQ"
        ],
        'bn' => [
            'lang'  => "bn-BD",
            'label' => "বাংলা - ベンガル語",
            'voice' => "WiaIVvI1gDL4vT4y7qUU"
        ],
        'zh' => [
            'lang'  => "zh-CN",
            'label' => "中文 - 中国語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'vi' => [
            'lang'  => "vi-VN",
            'label' => "Tiếng Việt - ベトナム語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'si' => [
            'lang'  => "si-LK",
            'label' => "සිංහල - シンハラ語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'id' => [
            'lang'  => "id-ID",
            'label' => "Bahasa Indonesia - インドネシア語",
            'voice' => "4h05pJAlcSqTMs5KRd8X"
        ],
        'ne' => [
            'lang'  => "ne-NP",
            'label' => "नेपाली - ネパール語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'mn' => [
            'lang'  => "mn-MN",
            'label' => "Монгол - モンゴル語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
        'my' => [
            'lang'  => "my-MM",
            'label' => "မြန်မာ - ミャンマー語",
            'voice' => "21m00Tcm4TlvDq8ikWAM"
        ],
    ];

    public static function getLangInfo($code)
    {
        $countryMap = [
            'ja' => 'JP',
            'en' => 'US',
            'es' => 'ES',
            'fr' => 'FR',
            'de' => 'DE',
            'zh' => 'CN',
            'vi' => 'VN',
            'bn' => 'BD',
            'si' => 'LK',
            'id' => 'ID',
            'ne' => 'NP',
            'mn' => 'MN',
            'my' => 'MM',
        ];

        return [
            'label' => self::langs[$code] ?? '',
            'lang_code' => $code . '-' . $countryMap[$code],
        ];
    }
}

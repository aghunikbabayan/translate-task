<?php

namespace App\Http\Services;

use Google\Cloud\Translate\V2\TranslateClient;
use Stichoza\GoogleTranslate\GoogleTranslate;
use App\Http\Contracts\Services\GoogleServices as Contract;

class GoogleService implements Contract
{
    /**
     * @var TranslateClient $clientTranslate
     */
    protected $clientTranslate;

    /**
     * @var string[] $codes Allowed translation codes
     */
    protected $codes = [
        'af', 'sq', 'am', 'ar', 'hy', 'az', 'eu', 'be', 'bn', 'bs', 'bg', 'ca', 'ceb', 'zh-CN', 'zh', 'zh-TW', 'co', 'hr', 'cs', 'da', 'nl', 'en', 'eo', 'et', 'fi', 'fr', 'fy', 'gl', 'ka', 'de', 'el',
        'gu', 'ht', 'ha', 'haw', 'he', 'iw', 'hi', 'hmn', 'hu', 'is', 'ig', 'id', 'ga', 'it', 'ja', 'jv', 'kn', 'kk', 'km', 'rw', 'ko', 'ku', 'ky', 'lo', 'la', 'lv', 'lt', 'lb', 'mk', 'mg', 'ms', 'ml',
        'mt', 'mi', 'mr', 'mn', 'my', 'ne', 'no', 'ny', 'or', 'ps', 'fa', 'pl', 'pt', 'pa', 'ro', 'ru', 'sm', 'gd', 'sr', 'st', 'sn', 'sd', 'si', 'sk', 'sl', 'so', 'es', 'su', 'sw', 'sv', 'tl', 'tg', 'ta',
        'tt', 'te', 'th', 'tr', 'tk', 'uk', 'ur', 'ug', 'uz', 'vi', 'cy', 'xh', 'yi', 'yo', 'zu',
    ];

    /**
     * GoogleService constructor.
     */
    public function __construct()
    {
        $key = env('GOOGLE_API_KEY');
        $this->clientTranslate = new TranslateClient([
            'key' => $key
        ]);
    }


    /**
     * @param string $text
     * @param string $language
     * @return array
     */
    public function translateTxtWithApi(string $text, string $language): array
    {
        $isValidLang = $this->isValidLang($language);
        if (!$isValidLang) {
            return ['success' => false, 'error' => 'incorrect language code'];
        }
        try {
            $translate = $this->clientTranslate->translate($text, [
                'target' => $language,
            ]);
            $result = ['success' => true, 'translation' => $translate['text']];

        } catch (\Exception $e) {
            $error = json_decode($e->getMessage(), true);
            $message = 'server error';
            if (isset($error['error']) && $error['error']['message']) {
                $message = $error['error']['message'];
            }

            $result = ['success' => false, 'error' => $message];
        }
        return (array)$result;

    }

    /**
     * @param string $text
     * @param string $language
     * @return array
     */
    public function translateTxtWithScript(string $text, string $language): array
    {
        $isValidLang = $this->isValidLang($language);
        if (!$isValidLang) {
            return ['success' => false, 'error' => 'incorrect language code'];
        }
        try {

            $tr = new GoogleTranslate($language);
            $text = $tr->translate($text);
            $result = ['success' => true, 'translation' => $text];

        } catch (\Exception $e) {
            $error = json_decode($e->getMessage(), true);
            $message = 'server error';
            if (isset($error['error']) && $error['error']['message']) {
                $message = $error['error']['message'];
            }
            $result = ['success' => false, 'error' => $message];
        }
        return (array)$result;
    }

    /**
     * Check if given language is valid.
     *
     * @param string $lang Language code to verify
     * @return bool
     */
    protected function isValidLang(string $lang): bool
    {
        return (boolean)in_array($lang, $this->codes);

    }
}

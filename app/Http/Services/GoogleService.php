<?php

namespace App\Http\Services;

use Google\Cloud\Translate\TranslateClient;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleService
{
    protected $clientTranslate;

    public function __construct()
    {
        $key = env('GOOGLE_API_KEY');
        $this->clientTranslate = new TranslateClient([
            'key' => $key
        ]);
    }


    public function translateTxtWithApi($text, $language)
    {
        try {
            $translate= $this->clientTranslate->translate($text, [
                'target' => $language,
            ]);
            $result = ['success' => true,'data'=>$translate['text']];

        } catch (\Exception $e) {
            $error= json_decode($e->getMessage(),true);
            $message= 'server error';
            if(isset($error['error']) && $error['error']['message']){
                $message= $error['error']['message'];
            }

            $result= ['success' => false, 'message' => [$message]];
        }
        return $result;

    }

    public function translateTxtWithScript($text, $language)
    {
        try {
            $tr = new GoogleTranslate($language);
            $text = $tr->translate($text);
            $result = ['success' => true,'data'=>$text];

        } catch (\Exception $e) {
            $error= json_decode($e->getMessage(),true);
            $message= 'server error';
            if(isset($error['error']) && $error['error']['message']){
                $message= $error['error']['message'];
            }
            $result= ['success' => false, 'message' => [$message]];
        }
        return $result;
    }

}
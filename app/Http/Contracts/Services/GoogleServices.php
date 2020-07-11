<?php

namespace App\Http\Contracts\Services;


interface  GoogleServices
{

    /**
     * translate text with GOOGLE API.
     *
     * @param  string  $text
     * @param  string  $language
    /**
     * @return [
     * 'success' => Boolean!,
     * 'error' => String,
     * 'translation' => String,
     * ]
     */

    public function translateTxtWithApi(string $text, string $language):array ;

    /**
     * translate text with SCRIPT.
     *
     * @param  string  $text
     * @param  string  $language
     * @return [
     * 'success' => Boolean!,
     * 'error' => String,
     * 'translation' => String,
     * ]
     */

    public function translateTxtWithScript(string $text,string $language):array ;
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\GoogleService;

class TranslateController extends Controller
{
   public function translate(Request $request,GoogleService $googleService){
       $text=$request->input('text');
       $language=$request->input('language');
       $translate=$googleService->translateTxtWithScript($text,$language);
       if(!$translate['success']){
           return response()->json(['success' => false, 'error' => $translate['message']], 400);

       }
       return response()->json(['success' => true, 'translation' => $translate['data']], 200);



   }


}

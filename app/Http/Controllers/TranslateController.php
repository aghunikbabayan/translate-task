<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Services\GoogleService;

class TranslateController extends Controller
{
    /**
     * @param Request $request
     * @param GoogleService $googleService
     * @return JsonResponse
     */
    public function translate(Request $request, GoogleService $googleService): JsonResponse
    {
        $text = $request->input('text');
        $language = $request->input('language');

        $translate = $googleService->translateTxtWithScript($text, $language);
        if (!$translate['success']) {
            return response()->json(['success' => false, 'error' => $translate['error']], 400);

        }
        return response()->json(['success' => true, 'translation' => $translate['translation']], 200);

    }


}

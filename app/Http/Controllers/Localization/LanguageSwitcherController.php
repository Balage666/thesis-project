<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LanguageSwitcherController extends Controller
{
    public function setLanguage(String $language) {

        session()->put('locale', $language);

        // dd(Cache::get("translations_$language"));
        return redirect()->back();
    }
}

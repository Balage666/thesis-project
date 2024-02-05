<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LanguageSwitcherController extends Controller
{
    //FIXME: Implement language switching method
    public function setLanguage(String $locale) {
        app()->setLocale($locale);

        // dd(Cache::get("translations_$language"));
        return redirect()->back();
    }
}

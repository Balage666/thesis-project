<?php

namespace App\Http\Controllers\Localization;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class LanguageSwitcherController extends Controller
{
    public function setLanguage(String $language) {

        app()->setLocale($language);
        // session()->put('locale', $language);
        Session::put('locale', $language);

        return redirect()->back();
    }
}

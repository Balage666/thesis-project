<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\View\Component;

class Translations extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $locale = App::getLocale();

        $phpTranslations = [];
        $jsonTranslations = [];

        // dd($locale, "lang/$locale", lang_path(), File::exists(lang_path("$locale.json")));

        if (File::exists(lang_path($locale))) {
            $phpTranslations = collect(
                File::allFiles(lang_path($locale))
            )->filter(function($file) {
                return $file->getExtension() === "php";
            })->flatMap(function($file) {
                return Arr::dot(File::getRequire($file->getRealPath()));
            })->toArray();

        }

        if (File::exists(lang_path("$locale.json"))) {
            $jsonTranslations = json_decode(File::get(lang_path("$locale.json")), true);
        }

        // dd($phpTranslations);

        $translations = array_merge($phpTranslations, $jsonTranslations);

        // dd($translations["Login"]["Hi!"]);

        return view('components.translations', [
            'translations' => $translations
        ]);
    }
}

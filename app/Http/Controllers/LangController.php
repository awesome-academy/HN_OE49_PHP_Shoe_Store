<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    public function switchLang(Request $request, $locale)
    {
        if (in_array($locale, config('app.available_locales'))) {
            $request->session()->put('locale', $locale);
            
            return redirect()->back();
        }
    }
}

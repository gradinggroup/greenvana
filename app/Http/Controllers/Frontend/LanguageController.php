<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    
    public function ind()
    {
        Session()->get('language');
        Session()->forget('language');
        Session()->put('language','ind');
        return redirect()->back();
    }

    public function en()
    {
        Session()->get('language');
        Session()->forget('language');
        Session()->put('language','en');
        return redirect()->back();
    }



}

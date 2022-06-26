<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    //
    public function setLocale(Request $request,$locale){
        session(['__app_localization'=>$locale]);
        return back();
    }
}

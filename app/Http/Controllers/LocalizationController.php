<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class LocalizationController extends Controller
{
    //
    public function setLocale(Request $request,$locale){
        Log::info("The session's locale setted to `$locale`");
        session(['__app_localization'=>$locale]);
        return back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(string $locale): RedirectResponse
    {
        if(in_array($locale , ['en' , 'ar']))
        {
            session(['locale' => $locale]);
        }

        return back();
    }
}

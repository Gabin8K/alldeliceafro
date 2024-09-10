<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function __invoke(Request $request, $language)
    {
//        Inertia::share('urlGenerator', function () {
//            return app('Illuminate\Routing\UrlGenerator');
//        });

//        if(!in_array($language, array_keys(config('available_languages')))){
//            return redirect('/');
//        }

        return Inertia::render('Welcome');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocaleController extends Controller
{
    public function __invoke(Request $request, $language, $newLocale)
    {
        $newLocale = in_array($newLocale, array_keys(config('available_languages'))) ? $newLocale : 'en';
        $previousRoute = app('router')->getRoutes()->match($request->create(url()->previous()));

        $newRouteParameters = array_merge(
            $previousRoute->parameters(), ['language' => $newLocale]
        );

        $queryParams = $request->create(url()->previous())->query();
        $newRouteParameters = array_merge($newRouteParameters, $queryParams);

        return Redirect::route($previousRoute->getName(), $newRouteParameters);
    }
}

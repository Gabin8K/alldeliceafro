<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage
{
    protected array $languages;
    protected string $defaultLanguage;

    public function __construct()
    {
        $this->languages = array_keys(config('available_languages'));
        $this->defaultLanguage = config('app.fallback_locale');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = $request->route('language');

        if (!in_array($language, $this->languages)) {
            $segments = $request->segments();
            $segments[0] = $this->defaultLanguage;

            $queryParams = $request->getQueryString();
            $redirectUrl = implode('/', $segments) . ($queryParams ? '?' . $queryParams : '');

            return redirect()->to($redirectUrl);
        }

        return $next($request);
    }
}

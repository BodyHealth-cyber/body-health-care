<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = ['ru', 'en', 'uk'];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestedLocale = $request->query('lang');

        if (!is_string($requestedLocale) || !in_array($requestedLocale, self::SUPPORTED_LOCALES, true)) {
            $requestedLocale = $request->query('locale');
        }

        if (is_string($requestedLocale) && in_array($requestedLocale, self::SUPPORTED_LOCALES, true)) {
            session(['locale' => $requestedLocale]);
            $locale = $requestedLocale;
        } else {
            $locale = session('locale', config('app.locale', 'ru'));
        }

        if (!in_array($locale, self::SUPPORTED_LOCALES, true)) {
            $locale = 'ru';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}

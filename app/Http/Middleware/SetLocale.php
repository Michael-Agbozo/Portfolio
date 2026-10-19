<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Picks the language for each visit: a language the visitor chose from the
 * menu (remembered in a cookie) wins; otherwise their browser's preferred
 * language is used if the site offers it; otherwise English.
 */
class SetLocale
{
    public const COOKIE = 'locale';

    public function handle(Request $request, Closure $next): Response
    {
        self::apply($request);

        $response = $next($request);
        $response->headers->set('Content-Language', App::getLocale());
        $response->setVary(array_unique(array_merge($response->getVary(), ['Accept-Language', 'Cookie'])));

        return $response;
    }

    /** Also used by error pages, which render without the web middleware. */
    public static function apply(Request $request): string
    {
        $supported = array_keys(config('app.supported_locales'));
        $chosen = $request->cookie(self::COOKIE);

        $locale = in_array($chosen, $supported, true)
            ? $chosen
            : ($request->getPreferredLanguage($supported) ?? config('app.fallback_locale'));

        App::setLocale($locale);

        return $locale;
    }
}

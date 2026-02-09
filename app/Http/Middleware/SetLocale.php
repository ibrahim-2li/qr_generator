<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales
     */
    public const SUPPORTED_LOCALES = [
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'dir' => 'ltr',
        ],
        'ar' => [
            'name' => 'Arabic',
            'native' => 'العربية',
            'dir' => 'rtl',
        ],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = Session::get('locale', config('app.locale', 'en'));

        if (! array_key_exists($locale, self::SUPPORTED_LOCALES)) {
            $locale = 'en';
        }

        App::setLocale($locale);

        return $next($request);
    }

    /**
     * Get the text direction for the current locale
     */
    public static function getDirection(?string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();

        return self::SUPPORTED_LOCALES[$locale]['dir'] ?? 'ltr';
    }

    /**
     * Check if current locale is RTL
     */
    public static function isRtl(?string $locale = null): bool
    {
        return self::getDirection($locale) === 'rtl';
    }
}

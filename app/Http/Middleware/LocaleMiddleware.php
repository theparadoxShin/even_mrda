<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is provided in the request
        if ($request->has('locale')) {
            $locale = $request->get('locale');
            if (in_array($locale, array_keys(config('app.available_locales')))) {
                Session::put('locale', $locale);
            }
        }

        // Get locale from session, or use app default
        $locale = Session::get('locale', config('app.locale'));
        
        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}

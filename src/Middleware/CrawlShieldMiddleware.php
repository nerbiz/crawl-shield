<?php

namespace Nerbiz\CrawlShield\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CrawlShieldMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = config('crawl-shield.enabled');
        $enabledInProduction = config('crawl-shield.enabled_in_production');
        $inProduction = app()->environment('production');

        // Skip this middleware if it's disabled
        if ($enabled === false || ($enabledInProduction === false && $inProduction)) {
            return $next($request);
        }

        $parameter = config('crawl-shield.parameter');
        $correctPassword = config('crawl-shield.password');
        $password = session('crawl-shield-password') ?? $request->query($parameter);

        if ($password !== $correctPassword) {
            abort(403);
        }

        // Set the password in the session for followup requests
        session()->put('crawl-shield-password', $password);

        return $next($request);
    }
}

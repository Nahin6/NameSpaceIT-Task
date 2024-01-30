<?php

namespace App\Http\Middleware;
use Illuminate\Http\RedirectResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Cache\RateLimiting\Limit;


class AntiSpamMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle(Request $request, Closure $next, $maxAttempts = 4, $decayMinutes = 1, $blockDuration = 5)
    {
        $key = $this->resolveRequestSignature($request);

        // Rate limit based on IP
        $limiterKey = 'url_shortener_' . $request->ip();
        $limit = Limit::perMinute($maxAttempts, $decayMinutes);

        // Check if the IP is blocked
        if (cache()->get('blocked_ip_' . $request->ip())) {
            abort(429, 'IP is blocked. Please try again later.');
        }

        // Check for too many attempts before hitting the rate limiter
        if (RateLimiter::tooManyAttempts($limiterKey, $limit->maxAttempts)) {
            // Block the IP address for the specified duration
            $this->blockIp($request->ip(), $blockDuration * 60);
            // return response('Too Many Attempts. IP is blocked for ' . $blockDuration . ' minutes.');

            return redirect()->route('urlPage')->with('error_message', 'Too Many Attempts. IP is blocked for ' . $blockDuration . ' minutes.');
        }

        // Hit the rate limiter
        RateLimiter::hit($limiterKey);

        return $next($request);
    }

    protected function resolveRequestSignature($request)
    {
        return sha1(
            $request->method() .
                '|' . $request->server('SERVER_NAME') .
                '|' . $request->path() .
                '|' . $request->ip()
        );
    }

    protected function blockIp($ip, $duration)
    {
        $cacheKey = 'blocked_ip_' . $ip;
        cache([$cacheKey => true], $duration);
    }
    // protected function generateBlockedResponse($blockDuration)
    // {
    //     return new RedirectResponse(route('errorPage', ['blockDuration' => $blockDuration]));
    // }
}

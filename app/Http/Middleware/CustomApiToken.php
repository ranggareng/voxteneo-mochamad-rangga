<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cache;

class CustomApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Cache::has('token')) {
            return redirect(route('login'));
        }

        $access_token = Cache::get('token');
        $exploded_access_token = explode('.', $access_token);

        try {
            if (isset($exploded_access_token[1])) {
                $payload = json_decode(base64_decode($exploded_access_token[1]), true);
                if ($payload['exp'] < now()->timestamp) {
                    Cache::forget(['token']);
                    return redirect(route('login'));
                } else {
                    return $next($request);
                }
            } else {
                return redirect(route('login'));
            }
        } catch (\Exception $e) {
            return redirect(route('login'));
        }
    }
}

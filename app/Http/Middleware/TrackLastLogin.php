<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackLastLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Only update if last login was more than 5 minutes ago (to avoid constant updates)
            if (!$user->last_login_at || $user->last_login_at->lt(now()->subMinutes(5))) {
                try {
                    $user->last_login_at = now();
                    $user->save();
                } catch (\Exception $e) {
                    // Silently fail to avoid breaking the request
                    Log::error('TrackLastLogin middleware error: ' . $e->getMessage());
                }
            }
        }

        return $next($request);
    }
}

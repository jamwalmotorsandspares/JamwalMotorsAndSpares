<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorHistory;

class TrackVisitorHistory
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only track successful GET pages
        if (
            $request->isMethod('GET') &&
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300
        ) {

            VisitorHistory::create([

                'user_id' => auth()->id(),

                'session_id' => $request->session()->getId(),

                'url' => $request->fullUrl(),

                'route_name' => optional($request->route())
                    ->getName(),

                'method' => $request->method(),

                'ip_address' => $request->ip(),

                'user_agent' => $request->userAgent(),

                'referer' => $request->header('referer'),
            ]);
        }

        return $response;
    }
}
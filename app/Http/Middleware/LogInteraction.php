<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use App\Events\InteractionEvent;
use Symfony\Component\HttpFoundation\Response;

class LogInteraction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        Event::dispatch(new InteractionEvent($request, $response));

        return $response;
    }
}

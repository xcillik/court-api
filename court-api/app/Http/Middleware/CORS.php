<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;

class CORS
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        // TODO
        if($request->getSchemeAndHttpHost() !== env("APP_URL"))
            return response()->json(["error" => "400 Bad Request"], HttpResponse::HTTP_BAD_REQUEST);
        
        return $next($request);
    }
}

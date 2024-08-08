<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         //if no token exists
        if(!$request->bearerToken()){
            return response('Unauthorized', 401);
        }
        //check for validity of the token
        $user = User::where('token', $request->bearerToken())->first();
        if(!$user){
            return response('Unauthorized', 401);
        }
        return $next($request);
    }
}

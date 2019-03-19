<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!$request->hasHeader('Authorization')) {
        return response()->json(['error' => 'missing auth parameter']);
      }
      $apiAuthKey = 'Bearer ' . config('app.api_auth_key');
      if ($request->header('Authorization') != $apiAuthKey) {
        return response()->json(['error' => 'incorrect auth key']);
      }
      return $next($request);
  
    }
}

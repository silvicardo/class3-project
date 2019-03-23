<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class FillUserProperties
{
    //non in uso provvisorio



    //ritorneremo l'utente tramite questa var
    public $attributes;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {

        $currentUser = Auth::user();

        $currentUser->role = $currentUser->roles()->first()->name;

        $currentUser->views = [
          'messages' => [
            'index' => 'admin.messages.index',
            'create' => 'admin.messages.create',
            'show' => 'admin.messages.show',
          ],
          'user' => [
            'profile' => "admin.{$currentUser->role}.profile",
            'dashboard' => "admin.{$currentUser->role}.dashboard",
            'edit' => "admin.{$currentUser->role}.edit",
          ],
        ];

        $currentUser->routes = [
          'messages' => [
            'index' => 'messages.index',
            'create' => 'messages.create',
            'store' => 'messages.store',
            'show' => 'messages.show',
            'destroy' => 'messages.destroy'
          ],
          'user' => [
            'profile' => "{$currentUser->role}.profile",
            'create' => "{$currentUser->role}.create",
            'store' => "{$currentUser->role}.store",
            'show' => "{$currentUser->role}.show",
            'destroy' => "{$currentUser->role}.destroy",
          ],
        ];
        // in Middleware register instance
          // app()->instance('User', $currentUser);
          // $request->attributes->add(['currentUser' => $currentUser]);
        $request->attributes->set('currentUser', $currentUser);
        // dd($request->attributes);
        return $next($request);
    }
}

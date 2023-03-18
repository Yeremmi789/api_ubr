<?php

namespace App\Http\Middleware;
// Agregado en el proceso de creacion del login y "TOKEN"
use Closure;
// Agregado en el proceso de creacion del login y "TOKEN"
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // Agregado en el proceso de creacion del login y "TOKEN"

    // public function handle($request, Closure $next, ...$guards)
    // {
    //     if($token = $request->cookie('cookie_token')){
    //         $request->headers-set('Authotization', 'Bearer'.$token);
    //     }
    //     $this->authenticate($request, $guards);

    //     return $next($request);
    // }
    // Agregado en el proceso de creacion del login y "TOKEN"

    public function handle($request, Closure $next, ...$guards)
    {
        if ($token = $request->cookie('cookie_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }
        $this->authenticate($request, $guards);
        return $next($request);
    }
}

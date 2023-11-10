<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RegisterSupplierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->hasRole(['fournisseur']) and !auth()->user()->status) {
            //session()->flash('message', 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
            toast('Veuillez finaliser votre inscription', 'warning')->autoClose(20000);
            return redirect()->route('onboarding');
        }

        return $next($request);
    }
}

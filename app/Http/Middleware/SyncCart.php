<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class SyncCart
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !session()->has('cart_synced')) {
            Cart::syncCart(Auth::id());
            session()->put('cart_synced', true);
        }
        
        return $next($request);
    }
}
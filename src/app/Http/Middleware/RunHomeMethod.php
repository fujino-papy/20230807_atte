<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RunHomeMethod
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // ログインしている場合、homeメソッドを実行
            $controller = app()->make(\App\Http\Controllers\StampController::class);
            $controller->home();
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\AccessControl\PermissionController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermissionIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::user()) PermissionController::permission_verify();

        return $next($request);
    }

}

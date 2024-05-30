<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if(auth()->check() && auth()->user()->role->permissions->contains(Permission::where('title', $permission)->first()->id)){
            return $next($request);
        }
        abort(403, 'You dont have the proper permissions to access this route');
    }
}

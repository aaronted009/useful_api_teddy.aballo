<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $authenticated_user = Auth::user();
        // Retrieve module ids
        $user_modules = $authenticated_user->modules;
        $user_module_ids = array();
        foreach ($user_modules as $module) {
            array_push($user_module_ids, $module->pivot->module_id);
        }
        if (!in_array($request->module, $user_module_ids)) {
            return response()->json([
                "error" => "Module inactive. Please activate this module to use it."
            ], 403);
        }
        return $next($request);
    }
}

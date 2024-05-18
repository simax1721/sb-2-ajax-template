<?php

namespace App\Http\Middleware;

use App\Models\Admin as ModelsAdmin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminCek
{

    static function get()
    {
        $admin = ModelsAdmin::where('users_id', Auth::user()->id)->first();
        return $admin;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $admincek): Response
    {
        $admin_access = ModelsAdmin::with('admin_role', 'admin_prodi')->where('users_id', Auth::user()->id)->first();

        if (in_array($admin_access->admin_roles_id, explode('|', $admincek))) {
            return $next($request);
        }

        return abort(403);
    }
}

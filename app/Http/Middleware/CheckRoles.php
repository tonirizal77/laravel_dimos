<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Role;

class CheckRoles
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string $role
     * @return mixed
     */

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user_role = Role::find(auth()->user()->role_id);
        // dump($user_role->name);
        // dump($role);
        foreach ($roles as $role) {
            if ($role == $user_role->name) {
                return $next($request);
            }
        }
        return abort(403,'Sorry!, Anda tidak punya hak akses.');
    }
}

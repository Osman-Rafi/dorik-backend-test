<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class RestrictedToAdminAndTeacherOnly
{
    public function handle($request, Closure $next)
    {
        $user_role = DB::table('users')->where('id', '=', auth()->user()->id)->value('role');

        if ($user_role === 1 || $user_role === 2) {
            return $next($request);

        }
        abort(403, 'Access denied');
        return "";
    }
}

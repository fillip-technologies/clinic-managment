<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Allow the request if the user holds ANY of the given permissions.
     * Usage: ->middleware('permission:appointments,onsite_appointments')
     */
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $user = User::currentAdmin();

        if (! $user) {
            return redirect()->route('login');
        }

        foreach ($permissions as $permission) {
            if ($user->hasPermission($permission)) {
                return $next($request);
            }
        }

        abort(403, 'You do not have access to this section.');
    }
}

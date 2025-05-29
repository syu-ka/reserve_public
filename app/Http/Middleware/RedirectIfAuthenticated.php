<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    // 現在、admin.dashboard.index ルートは存在しないため、コメントアウト.必要になったら復活する.controllerの方も同時に修正すること.app\Http\Controllers\Admin\Auth\AuthenticatedSessionController.php
                    // return redirect()->route('admin.dashboard');
                    return redirect()->route('admin.lessons.index');
                }
                if ($guard === 'student') {
                    // 現在、student.dashboard.index ルートは存在しないため、コメントアウト.必要になったら復活する.controllerの方も同時に修正すること.app\Http\Controllers\Student\Auth\AuthenticatedSessionController.php
                    // return redirect()->route('student.dashboard');
                    return redirect()->route('student.reservations.index');
                }
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
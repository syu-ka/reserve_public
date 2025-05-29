<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {

        if ($request->expectsJson()) {
            return null;
        }

         // すでにloginページならリダイレクトしない
        if (
            $request->routeIs('login') ||
            $request->routeIs('register') ||
            $request->routeIs('password.*') ||
            $request->routeIs('admin.login') ||
            $request->routeIs('student.login') ||
            $request->is('login') ||
            $request->is('admin/login') ||
            $request->is('student/login')
        ) {
            return null;
        }
        

        // URLやガードで分岐
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }
        if ($request->is('student') || $request->is('student/*')) {
            return route('student.login');
        }

        return route('student.login');
    }
}
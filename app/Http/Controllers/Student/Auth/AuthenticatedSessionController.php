<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('student.auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'id' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('student')->attempt($credentials)) {
            $request->session()->regenerate();
            // return redirect()->intended(route('student.dashboard'));
            return redirect()->route('student.dashboard');
        }

        return back()->withErrors([
            'id' => 'IDまたはパスワードが正しくありません。',
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('student')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('student.login');
    }
}


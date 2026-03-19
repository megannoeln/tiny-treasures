<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($validated, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Invalid credentials.']);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

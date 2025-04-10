<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SingInController extends Controller
{
    /**
     * Show the sign-in form.
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard.parts');
        }
        return view('auth.sign-in');
    }

    /**
     * Handle the sign-in request.
     */
    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.parts'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Handle the sign-out request.
     */
    public function signOut(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.sign-in');
    }
}

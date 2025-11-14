<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** Handle a login request. Accepts JSON or form requests. */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->intended('/dashboard');
        }

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}

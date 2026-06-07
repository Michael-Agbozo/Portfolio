<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $user = Auth::user();

        if ($user->hasTwoFactorEnabled()) {
            // Don't fully sign them in yet — first they must enter their
            // authenticator code on the two-factor challenge page.
            Auth::logout();

            $request->session()->put('2fa_user_id', $user->id);
            $request->session()->put('2fa_remember', $remember);

            return redirect()->route('two-factor.challenge');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard.index'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

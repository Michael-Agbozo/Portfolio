<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorChallengeController extends Controller
{
    public function show(Request $request)
    {
        if (! $request->session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $userId = $request->session()->get('2fa_user_id');
        $user = $userId ? User::find($userId) : null;

        if (! $user) {
            return redirect()->route('login');
        }

        $code = trim($request->input('code'));

        if ($this->isValidTotpCode($user, $code) || $this->isValidRecoveryCode($user, $code)) {
            $remember = $request->session()->pull('2fa_remember', false);
            $request->session()->forget('2fa_user_id');

            Auth::login($user, $remember);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.index'));
        }

        return back()->withErrors(['code' => 'That code is invalid or has expired.']);
    }

    private function isValidTotpCode(User $user, string $code): bool
    {
        return (bool) $user->two_factor_secret
            && (new Google2FA)->verifyKey($user->two_factor_secret, $code);
    }

    private function isValidRecoveryCode(User $user, string $code): bool
    {
        $codes = $user->two_factor_recovery_codes ?? [];

        $matched = null;
        foreach ($codes as $stored) {
            if (hash_equals($stored, $code)) {
                $matched = $stored;
            }
        }

        if ($matched === null) {
            return false;
        }

        $user->forceFill([
            'two_factor_recovery_codes' => array_values(array_diff($codes, [$matched])),
        ])->save();

        return true;
    }
}

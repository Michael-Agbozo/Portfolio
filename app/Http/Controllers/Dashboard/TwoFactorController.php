<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use PragmaRX\Google2FAQRCode\Google2FA;

class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $qrCode = null;

        if ($user->two_factor_secret && ! $user->hasTwoFactorEnabled()) {
            $qrCode = (new Google2FA)->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->two_factor_secret
            );
        }

        return view('dashboard.security.index', [
            'user' => $user,
            'qrCode' => $qrCode,
        ]);
    }

    /** Start setup: generate a new (unconfirmed) secret and show its QR code. */
    public function enable(Request $request)
    {
        $request->user()->forceFill([
            'two_factor_secret' => (new Google2FA)->generateSecretKey(),
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return redirect()->route('dashboard.security.index');
    }

    /** Finish setup: verify the code from the authenticator app and turn 2FA on. */
    public function confirm(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $user = $request->user();

        if (! $user->two_factor_secret || ! (new Google2FA)->verifyKey($user->two_factor_secret, trim($request->code))) {
            return back()->withErrors(['code' => 'That code did not match. Please try again.']);
        }

        $user->forceFill([
            'two_factor_recovery_codes' => $this->generateRecoveryCodes(),
            'two_factor_confirmed_at' => now(),
        ])->save();

        return redirect()->route('dashboard.security.index')
            ->with('success', 'Two-factor authentication is turned on. Save your recovery codes somewhere safe — you will need one if you ever lose access to your authenticator app.');
    }

    public function disable(Request $request)
    {
        $request->validate(['password' => 'required|current_password']);

        $request->user()->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return redirect()->route('dashboard.security.index')->with('success', 'Two-factor authentication has been turned off.');
    }

    public function regenerateRecoveryCodes(Request $request)
    {
        $user = $request->user();

        abort_unless($user->hasTwoFactorEnabled(), 404);

        $user->forceFill(['two_factor_recovery_codes' => $this->generateRecoveryCodes()])->save();

        return redirect()->route('dashboard.security.index')
            ->with('success', 'New recovery codes have been generated. Your old codes will no longer work.');
    }

    private function generateRecoveryCodes(): array
    {
        return collect(range(1, 8))
            ->map(fn () => Str::lower(Str::random(4).'-'.Str::random(4)))
            ->all();
    }
}

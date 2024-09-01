<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    // Step 1: Send password reset link
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['account_email_address' => 'required|email']);

        // Check if the email exists in the account table
        $account = Account::where('account_email_address', $request->account_email_address)->first();

        if (!$account) {
            return back()->withErrors(['account_email_address' => 'E-mail address not found.']);
        }

        // Send the password reset link
        $status = Password::broker('accounts')->sendResetLink(
            ['account_email_address' => $request->account_email_address]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['account_email_address' => __($status)]);
    }

    // Step 2: Show the reset form
    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'account_email_address' => $request->account_email_address]
        );
    }

    // Step 2further: Handle the password reset
    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'account_email_address' => 'required|string|email',
            'account_password' => 'required|string|min:8|confirmed',
        ]);

        // Map the validated data to the format expected by the PasswordBroker
        $credentials = [
            'account_email_address' => $request->account_email_address,
            'password' => $request->account_password,
            'password_confirmation' => $request->account_password_confirmation,
            'token' => $request->token,
        ];

        $status = Password::broker('accounts')->reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'account_password' => Hash::make($password),
                ])->save();

                $user->setRememberToken(Str::random(60));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['account_email_address' => [__($status)]]);
    }
}

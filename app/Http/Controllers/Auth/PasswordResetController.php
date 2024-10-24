<?php

namespace App\Http\Controllers\Auth;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    // Step 1: Send password reset link
    public function sendResetLinkEmail(Request $request) {
        $request->validate(['account_email_address' => 'required|email']);

        // Check if the email exists in the account table
        $account = Account::where('account_email_address', $request->account_email_address)->first();

        if (!$account) {
            return back()->withErrors(['account_email_address' => 'E-mail address not found. Please check your email address and try again.']);
        }

        // Send the password reset link
        $status = Password::broker('accounts')->sendResetLink(
            ['account_email_address' => $request->account_email_address]
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'An email with a password reset link has been sent. Please check your email address to continue with resetting your password.')
            : back()->withErrors(['account_email_address' => __($status)]);
    }

    // Step 2: Show the reset form
    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'account_email_address' => $request->query('email')]
        );
    }

    // Step 3: Handle the password reset
    public function reset(Request $request) {
        // Custom validation messages
        $messages = [
            'new_account_password.confirmed' => 'The password and confirm password fields do not match. Please try again.',
        ];

        $request->validate([
            'token' => 'required',
            'account_email_address' => 'required|string|email',
            'new_account_password' => 'required|string|min:8|confirmed',
        ], $messages);

        // Map the validated data to the format expected by the PasswordBroker
        $credentials = [
            'account_email_address' => $request->account_email_address,
            'password' => $request->new_account_password,
            'password_confirmation' => $request->new_account_password_confirmation,
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
            ? redirect()->route('login')->with('success', 'Account password reset successfully!')
            : back()->withErrors(['account_email_address' => [__($status)]]);
    }

    // Different case of changing password, for user already logged in
    public function changePassword(Request $request) {
        // Custom validation messages
        $messages = [
            'new_account_password.confirmed' => 'The password and confirm password fields do not match. Please try again.',
        ];

        $request->validate([
            'current_password' => 'required|string',
            'new_account_password' => 'required|string|min:8|confirmed',
        ], $messages);

        $account = Account::where('account_id', currentAccount()->account_id)->firstOrFail();

        if (!Hash::check($request->current_password, $account->account_password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect. Please try again.'])->withInput();
        }

        // Update the user's password
        $account->account_password = Hash::make($request->new_account_password);
        $status = $account->save();

        // Redirect back with a success message
        return $status
            ? redirect()->route('my-profile')->with('success', 'Account password changed successfully!')
            : back()->withErrors(['account_email_address' => [__($status)]]);
    }
}

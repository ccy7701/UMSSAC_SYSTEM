<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Validation\ValidationException;

class EmailVerificationController extends Controller
{
    public function verify(Request $request) {
        // Retrieve the user based on the ID
        $account = Account::findOrFail($request->account_id);

        // Ensure the email is unverified and the verification link is valid
        if (!$account->hasVerifiedEmail()) {
            // Check if the URL is valid and matches the user's verification URL
            if (!URL::hasValidSignature($request)) {
                throw new ValidationException('Invalid verification link.');
            }

            // Mark the email as verified
            $account->markEmailAsVerified();
        }

        // Log the user in
        Auth::login($account);

        // Redirect to the my-profile page
        return redirect()->route('my-profile')->with('email_verified', 'Your email has successfully been verified.');
    }
}

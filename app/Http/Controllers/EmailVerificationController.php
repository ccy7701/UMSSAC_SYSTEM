<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        // Log the user in if not already
        if (!Auth::check()) {
            Auth::login($account);
        }

        // Redirect to the my-profile page
        return redirect()->route('my-profile')->with('email_verified', 'Your email has successfully been verified.');
    }
    
    public function resendVerification() {
        // Get the currently authenticated user
        $account = currentAccount();

        // Check if the email is already verified
        if ($account->email_verified_at !== null) {
            return redirect()->route('my-profile')->with('already_verified', 'Your email is already verified.');
        }

        // Generate the signed verification URL
        $verificationUrl = URL::signedRoute('verification.auth.verify', ['account_id' => $account->account_id]);

        // Send the verification email
        Mail::to($account->account_email_address)->send(new VerificationEmail($account, $verificationUrl));

        return redirect()->route('my-profile')->with('email_sent', 'Please check your inbox for the verification email. Follow the instructions in the email to verify your account and continue.');
    }
}

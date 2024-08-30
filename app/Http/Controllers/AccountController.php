<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function register(Request $request) {
        // KEEP IN VIEW -> USE YOUR PARAMETERS!
        $validator = Validator::make($request->all(), [
            'accountFullName' => 'required|string|max:255',
            'accountEmailAddress' => 'required|string|email|max:255|unique:account,accountEmailAddress',
            'accountPassword' => 'required|string|min:8|confirmed',
            'accountRole' => 'required|in:1,2,3',
            'accountMatricNumber' => 'required_if:accountRole,1|nullable|string|max:10|unique:account,accountMatricNumber',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the account
        $account = Account::create([
            'accountFullName' => $request->accountFullName,
            'accountEmailAddress' => $request->accountEmailAddress,
            'accountPassword' => Hash::make($request->accountPassword),
            'accountRole' => $request->accountRole,
            'accountMatricNumber' => $request->accountRole == 1 ? $request->accountMatricNumber : null,
        ]);

        // Also create the corresponding empty profile
        Profile::create([
            'accountID' => $account->accountID,
            'profileNickname' => '',
            'profilePersonalDesc' => '',
            'profileEnrolmentSession' => $request->accountRole == 1 ? '' : null,
            'profileFaculty' => '',
            'profileProgramme' => '',
            'profilePictureFilePath' => '',
            'profileColourTheme' => '',
        ]);

        Auth::login($account);

        return redirect()->route('profile');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'accountRole' => 'required',
            'accountMatricNumber' => 'required_if:accountRole,1',
            'accountEmailAddress' => 'required_if:accountRole,2,3',
            'accountPassword' => 'required',
        ]);

        // Determine the field to authenticate with
        $field = $request->accountRole == "1" ? 'accountMatricNumber' : 'accountEmailAddress';

        // Find the account using the provided identifier (matric number or email)
        $account = Account::where($field, $request->$field)
            ->where('accountRole', $request->accountRole)
            ->first();

        // CASE 1: If the account exists
        if (!$account) {
            return back()->withErrors([
                $field => 'We could not find an account for the login credentials you entered. Please re-enter your credentials and try again or <a href="' . route('register') . '">register an account</a>.',
            ]);
        }

        // CASE 2: Password does not match
        if (!Hash::check($request->accountPassword, $account->accountPassword)) {
            return back()->withErrors([
                'accountPassword' => 'Incorrect password. Please try again.',
            ])->withInput();
        }

        // CASE 3: If everything is correct, log the user in
        Auth::login($account);
        $request->session()->regenerate();
        return redirect()->intended('profile');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

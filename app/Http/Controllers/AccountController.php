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

        // Check if the account exists and the password matches
        if ($account && Hash::check($request->accountPassword, $account->accountPassword)) {
            Auth::login($account);
            $request->session()->regenerate();
            return redirect()->intended('profile');
        }

        return back()->withErrors([
            $field => 'Login error: Your credentials do not match any account. Please try again.', // KIV
        ]);
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

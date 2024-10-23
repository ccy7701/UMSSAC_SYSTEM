<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Services\AccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService) {
        $this->accountService = $accountService;
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'account_full_name' => 'required|string|max:255',
            'account_email_address' => 'required|string|email|max:255|unique:account,account_email_address',
            'account_password' => 'required|string|min:8|confirmed',
            'account_role' => 'required|in:1,2,3',
            'account_matric_number' => 'required_if:account_role,1|nullable|string|max:10|unique:account,account_matric_number',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $account = $this->accountService->createAccount($request);
        $profile = $this->accountService->createProfile($request, $account);
        $this->accountService->createUserPreference($profile);
        
        Auth::login($account);

        return redirect()->route('my-profile');
    }

    public function login(Request $request) {
        $request->validate([
            'account_role' => 'required',
            'account_matric_number' => 'required_if:account_role,1',
            'account_email_address' => 'required_if:account_role,2,3',
            'account_password' => 'required',
        ]);

        // Determine the field to authenticate with
        $field = $request->account_role == "1" ? 'account_matric_number' : 'account_email_address';

        // Find the account using the provided identifier (matric number or email)
        $account = Account::where($field, $request->$field)
            ->where('account_role', $request->account_role)
            ->first();

        // CASE 1: If the account exists
        if (!$account) {
            return back()->withErrors([
                $field => 'We could not find an account for the login credentials you entered. Please re-enter your credentials and try again or <a href="' . route('register') . '">register an account</a>.',
            ]);
        }

        // CASE 2: Password does not match
        if (!Hash::check($request->account_password, $account->account_password)) {
            return back()->withErrors([
                'account_password' => 'The password you entered was incorrect. Please try again.',
            ])->withInput();
        }

        // CASE 3: If everything is correct, log the user in
        Auth::login($account);
        $request->session()->regenerate();
        return redirect()->intended('my-profile');
    }

    public function logout(Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Get all system users (ADMIN)
    public function fetchAllSystemUsers(Request $request) {
        return $this->accountService->prepareAndRenderSystemUsersView($request);
    }

    public function clearFilters() {
        $this->accountService->flushUsersSearchFilters();

        return redirect()->route('admin.all-system-users');
    }
}

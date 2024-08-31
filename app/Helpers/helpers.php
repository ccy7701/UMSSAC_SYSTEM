<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('currentAccount')) {
    function currentAccount() {
        return Auth::user();
    }
}

if (!function_exists('profile')) {
    function profile() {
        return Auth::user()->profile;
    }
}
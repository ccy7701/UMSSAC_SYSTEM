<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    <main>
        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Left section (Form) -->
                <div class="col-lg-6 p-3 d-flex">
                    <div class="row px-md-5 px-sm-1 py-4 text-start">
                        <div class="col-12">
                            <a href="{{ route('welcome') }}">
                                <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                            </a>
                            <br><br>
                            <div class="row text-start">
                                <h1 class="rslab fw-bold">
                                    Reset password
                                </h1>
                                <p class="rslab fs-4">Fill in the details below to reset your password.</p>
                                <!-- RESET PASSWORD FORM -->
                                @if ($errors->any())
                                    <br><br><br>
                                    <div class="rsans alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <i class="fa fa-circle-exclamation px-2"></i>
                                            {{$error}}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('password.update') }}" class="py-3">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="mb-3">
                                        <label for="email-address" class="rsans form-label fw-semibold">E-mail address</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                            <input type="email" id="email-address" name="account_email_address" class="rsans form-control" value="{{ old('account_email_address', $account_email_address) }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new-password" class="rsans form-label fw-semibold">New password (minimum 8 characters)</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user-lock d-flex"></i></span>
                                            <input type="password" id="new-password" name="new_account_password" class="rsans form-control" required autofocus>
                                            <span class="input-group-text d-flex justify-content-center password-toggle" data-target="new-password">
                                                <i class="fa fa-eye" id="eye-icon-pwd"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new-password-confirmation" class="rsans form-label fw-semibold">Confirm new password</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-unlock-keyhole"></i></span>
                                            <input type="password" id="new-password-confirmation" name="new_account_password_confirmation" class="rsans form-control" required autofocus>
                                            <span class="input-group-text d-flex justify-content-center password-toggle" data-target="new-password-confirmation">
                                                <i class="fa fa-eye" id="eye-icon-cnfm-pwd"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center py-3">
                                        <button type="submit" class="rsans btn btn-primary fw-semibold w-50">Reset password</button>
                                    </div>
                                </form>
                                <!-- RESET PASSWORD FORM -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right section (illustration) -->
                <div class="col-lg-6 p-0 d-none d-lg-block">
                    <img src="{{ asset('images/reset_password_illustration.jpg') }}" alt="Reset password illustration" class="img-fluid h-100 w-100 object-fit-cover">
                </div>
            </div>
        </div>
    </main>
</body>

</html>

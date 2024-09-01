<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X_UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/sass/app.scss')
</head>

<body style="height: 100%; overflow: hidden">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left section (Form) -->
            <div class="col-md-6 p-3 d-flex">
                <div class="row px-5 py-4 text-start">
                    <div class="col-12">
                        <a href="#">
                            <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                        </a>
                        <br><br>
                        <div class="row text-start">
                            <h1 class="rslab fw-bold">
                                Reset password
                            </h1>
                            <p class="rslab fs-4">Fill in the details below to reset your password.</p>
                            <!-- RESET PASSWORD FORM -->
                            <form method="POST" action="{{ route('password.update') }}" class="py-3">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="mb-3">
                                    <label for="email-address" class="rsans form-label fw-semibold">E-mail address</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                        <input type="email" id="email-address" name="account_email_address" class="form-control" value="{{ old('account_email_address', $account_email_address) }}" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new-password" class="rsans form-label fw-semibold">New password (minimum 8 characters)</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-lock d-flex"></i></span>
                                        <input type="password" id="new-password" name="account_password" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new-password-confirmation" class="rsans form-label fw-semibold">Confirm new password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-check-circle"></i></span>
                                        <input type="password" id="new-password-confirmation" name="account_password_confirmation" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center py-3">
                                    <button type="submit" class="btn btn-primary" style="width: 50%;">Reset password</button>
                                </div>
                            </form>
                            @if ($errors->any())
                                <br>
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{$error}}
                                    @endforeach
                                </div>
                            @endif
                            <!-- RESET PASSWORD FORM -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    @vite('resources/sass/app.scss')
</head>

<body style="height: 100%; overflow: hidden">
    <x-email-sent-message/>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left section (Form) -->
            <div class="col-md-6 p-3 d-flex">
                <div class="row px-5 py-4 text-start">
                    <div class="col-12">
                        <a href="{{ route('welcome') }}">
                            <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                        </a>
                        <br><br>
                        <div class="row text-start">
                            <h1 class="rslab fw-bold">
                                Forgot password?
                            </h1>
                            <p class="rslab fs-4">Enter the email address you used to register your account. We'll send you instructions to reset your password.</p>
                            <!-- RESET PASSWORD FORM -->
                            <form method="POST" action="{{ route('password.email') }}" class="py-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="email-address" class="rsans form-label fw-semibold">E-mail address</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                        <input type="email" id="email-address" name="account_email_address" class="rsans form-control" required autofocus">
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-center my-3">
                                        <button type="submit" class="rsans btn btn-primary fw-bold" style="width: 50%;">Send recovery email</button>
                                    </div>
                                </div>
                            </form>
                            <!-- END RESET PASSWORD FORM -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right section (illustration) -->
            <div class="col-md-6 p-0 d-none d-md-block">
                <img src="{{ asset('images/reset_password_illustration.jpg') }}" alt="Reset password illustration" class="img-fluid h-100 w-100 object-fit-cover">
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>

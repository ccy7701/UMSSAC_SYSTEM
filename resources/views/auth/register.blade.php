<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/registerForm.js')
    <main>
        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Left section (register form) -->
                <div class="col-lg-6 p-3 d-flex">
                    <div class="row px-md-5 px-sm-1 py-4 text-start">
                        <div class="col-12">
                            <a href="{{ route('welcome') }}">
                                <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                            </a>
                            <br><br>
                            <div class="row text-start">
                                <h1 class="rslab fw-bold">Register an account</h1>
                                <p class="rslab fs-4">One step away from your academic companion</p>
                                <!-- REGISTRATION FORM -->
                                @if ($errors->any())
                                    <br>
                                    <div class="rsans alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <i class="fa fa-circle-exclamation px-2"></i>
                                            {{ $error }}
                                            <br>
                                        @endforeach
                                    </div>
                                @endif
                                <form method="POST" action="{{ route('account.register') }}" class="py-3">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="full-name" class="rsans form-label fw-semibold">Full name</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user"></i></span>
                                            <input type="text" id="full-name" name="account_full_name" class="rsans form-control" value="{{ old('account_full_name') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nickname" class="rsans form-label fw-semibold">Nickname (optional)</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa-regular fa-user"></i></span>
                                            <input type="text" id="nickname" name="profile_nickname" class="rsans form-control" value="{{ old('profile_nickname') }}" autofocus>
                                        </div>
                                        <p class="rsans form-text text-start">You may leave this empty if you want to fill in a nickname later.</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email-address" class="rsans form-label fw-semibold">E-mail address</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                            <input type="email" id="email-address" name="account_email_address" class="rsans form-control" value="{{ old('account_email_address') }}" required autofocus>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="rsans form-label fw-semibold">Password (minimum 8 characters)</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user-lock d-flex"></i></span>
                                            <input type="password" id="password" name="account_password" class="rsans form-control" required autofocus>
                                            <span class="input-group-text d-flex justify-content-center password-toggle" data-target="password">
                                                <i class="fa fa-eye" id="eye-icon-pwd"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password-confirmation" class="rsans form-label fw-semibold">Confirm password</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-unlock-keyhole"></i></span>
                                            <input type="password" id="password-confirmation" name="account_password_confirmation" class="rsans form-control" required autofocus>
                                            <span class="input-group-text d-flex justify-content-center password-toggle" data-target="password-confirmation">
                                                <i class="fa fa-eye" id="eye-icon-cnfm-pwd"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role-select" class="rsans form-label fw-semibold">I am registering as a</label>
                                        <select class="rsans form-select" id="role-select" name="account_role">
                                            <option selected disabled value="">Choose...</option>
                                            <option value="1">Student</option>
                                            <option value="2">Faculty member</option>
                                            <option value="3">Admin</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a user role.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="matric-number" class="rsans form-label fw-semibold">Matric number</label>
                                        <div class="input-group">
                                            <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                                            <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" value="{{ old('account_matric_number') }}" oninput="this.value = this.value.toUpperCase();" autofocus>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center py-3">
                                        <button type="submit" class="rsans btn btn-primary fw-bold" style="width: 50%;">Register account</button>
                                    </div>
                                </form>
                                <!-- END REGISTRATION FORM -->
                                <div class="my-1">
                                    <p class="rsans">Already have an account? <a href="{{ route('login') }}" class="rsans fw-semibold link-dark">Log in</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Right section (illustration) -->
                <div class="col-lg-6 p-0 d-none d-lg-block">
                    <img src="{{ asset('images/register_illustration.jpg') }}" alt="Register page illustration" class="img-fluid h-100 w-100 object-fit-cover">
                </div>
            </div>
        </div>
    </main>
</body>

</html>

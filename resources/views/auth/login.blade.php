<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    @vite('resources/js/app.js')
    @vite('resources/js/loginFormRoleSelector.js')
    <x-success-message/> <!-- Flash message component -->
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left section (login form) -->
            <div class="col-md-6 p-3 d-flex">
                <div class="row px-5 py-4 text-start">
                    <div class="col-12">
                        <a href="{{ route('welcome') }}">
                            <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                        </a>
                        <br><br>
                        <div class="row text-start">
                            <h1 class="rslab fw-bold">Welcome back</h1>
                            <p class="rslab fs-4">Login to continue and use UMSSACS tools</p>

                            <!-- LOGIN FORM -->
                            @if ($errors->any())
                                <br>
                                <div class="rsans alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {!! $error !!}
                                        <br>
                                    @endforeach
                                </div>
                            @endif
                            <form method="POST" action="{{ route('account.login') }}" class="py-3">
                                @csrf
                                <!-- Role selection -->
                                <div class="mb-3">
                                    <fieldset class="mb-3 align-items-center" style="border: none; padding: 0;">
                                        <legend class="rsans form-label fw-semibold mb-1" style="font-size: inherit; margin-bottom: 0;">Select user role</legend>
                                        <div>
                                            <input type="radio" id="account-role-student" name="account_role" value="1" checked>
                                            <label for="account-role-student" class="rsans px-2 form-label">Student</label>
                                            
                                            <input type="radio" id="account-role-facultymember" name="account_role" value="2">
                                            <label for="account-role-facultymember" class="rsans px-2 form-label">Faculty Member</label>
                                            
                                            <input type="radio" id="account-role-admin" name="account_role" value="3">
                                            <label for="account-role-admin" class="rsans px-2 form-label">Admin</label>
                                        </div>
                                    </fieldset>
                                </div>
                                <!-- End role selection -->
                                <!-- Login credentials -->
                                <!-- Email/Matric Number Input -->
                                <div id="identifier-field" class="mb-3">
                                    <!-- Default to student -->
                                    <label for="matric-number" class="rsans form-label fw-semibold">Matric number</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                                        <input type="text" id="matric-number" name="account_matric_number" class="rsans form-control" required autofocus>
                                    </div>
                                </div>
                                <!-- Password Input -->
                                <div class="mb-3">
                                    <label for="password" class="rsans form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user-lock"></i></span>
                                        <input type="password" id="password" name="account_password" class="rsans form-control" required>
                                    </div>
                                </div>
                                <div class="my-4 text-end">
                                    <a href="{{ route('forgot-password') }}" class="rsans fw-semibold link-dark"><u>Forgot password?</u></a>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="rsans btn btn-primary fw-bold" style="width: 50%;">Log in</button>
                                </div>
                                <!-- End login credentials -->
                            </form>
                            <!-- END LOGIN FORM -->
                            <div class="my-2">
                                <p class="rsans">New user? <a href="{{ route('register') }}" class="rsans fw-semibold link-dark"><u>Register here</u></a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right section (illustration) -->
            <div class="col-md-6 p-0 d-none d-md-block">
                <img src="{{ asset('images/login_illustration.jpg') }}" alt="Login page illustration" class="img-fluid h-100 w-100 object-fit-cover">
            </div>
        </div>
    </div>
</body>

</html>

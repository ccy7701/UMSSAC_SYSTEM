<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/sass/app.scss')
</head>

<body>
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
                            <form method="POST" action="{{ route('account.login') }}" class="py-3">
                                @csrf
                                <!-- Role selection -->
                                <div class="mb-3">
                                    <div class="mb-3 align-items-center">
                                        <label class="rsans form-label fw-semibold">Select user role</label>
                                        <div>
                                            <input type="radio" id="accountRoleStudent" name="accountRole" value="1" checked>
                                            <label for="accountRoleStudent" class="px-2 form-label">Student</label>
                                            <input type="radio" id="accountRoleFacultyMember" name="accountRole" value="2">
                                            <label for="accountRoleFacultyMember" class="px-2 form-label">Faculty Member</label>
                                            <input type="radio" id="accountRoleAdmin" name="accountRole" value="3">
                                            <label for="accountRoleAdmin" class="px-2 form-label">Admin</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End role selection -->
                                <!-- Login credentials -->
                                <!-- Email/Matric Number Input -->
                                <div id="identifierField" class="mb-3">
                                    <!-- Default to student -->
                                    <label for="matricNumber" class="rsans form-label fw-semibold">Matric number</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                                        <input type="text" id="matricNumber" name="accountMatricNumber" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <!-- Password Input -->
                                <div class="mb-3">
                                    <label for="password" class="rsans form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-lock"></i></span>
                                        <input type="password" id="password" name="accountPassword" class="form-control" required>
                                    </div>
                                </div>
                                <div class="my-4 text-end">
                                    <a href="{{ route('reset_password') }}" class="rsans fw-semibold link-dark"><u>Forgot password?</u></a>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary" style="width: 50%;">Log in</button>
                                </div>
                                @if ($errors->any())
                                    <br>
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            {{$error}}
                                        @endforeach
                                    </div>
                                @endif
                                <!-- End login credentials -->
                            </form>
                            <!-- END LOGIN FORM -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const identifierField = document.getElementById('identifierField');
                                    const roleRadios = document.querySelectorAll('input[name="accountRole"]');

                                    function updateLoginForm() {
                                        const selectedRole = document.querySelector('input[name="accountRole"]:checked').value;

                                        if (selectedRole === "1") {
                                            identifierField.innerHTML = `
                                                <label for="matricNumber" class="rsans form-label fw-semibold">Matric number</label>
                                                <div class="input-group">
                                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                                                    <input type="text" id="matricNumber" name="accountMatricNumber" class="form-control" required autofocus>
                                                </div>
                                            `;
                                        } else if (selectedRole === "2") {
                                            identifierField.innerHTML = `
                                                <label for="fm_emailAddress" class="rsans form-label fw-semibold">Faculty member e-mail address</label>
                                                <div class="input-group">
                                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                                    <input type="text" id="fm_emailAddress" name="accountEmailAddress" class="form-control" required autofocus>
                                                </div>
                                            `;
                                        } else {
                                            identifierField.innerHTML = `
                                                <label for="ad_emailAddress" class="rsans form-label fw-semibold">Admin e-mail address</label>
                                                <div class="input-group">
                                                    <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                                    <input type="text" id="ad_emailAddress" name="accountEmailAddress" class="form-control" required autofocus>
                                                </div>
                                            `;
                                        }
                                    }

                                    roleRadios.forEach(radio => {
                                        radio.addEventListener('change', updateLoginForm);
                                    });

                                    // Initialise form based on default selected role
                                    updateLoginForm();
                                });
                            </script>
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
    @vite('resources/js/app.js')
</body>

</html>
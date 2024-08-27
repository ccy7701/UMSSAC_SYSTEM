<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/sass/app.scss')
</head>

<body style="">
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left section (register form) -->
            <div class="col-md-6 p-3 d-flex">
                <div class="row px-5 py-4 text-start">
                    <div class="col-12">
                        <a href="{{ route('welcome') }}">
                            <img src="{{ asset('images/umssacs_logo_final.png') }}" alt="UMSSACS logo" class="pb-4 img-fluid" style="width: 40.00%;">
                        </a>
                        <br><br>
                        <div class="row text-start">
                            <h1 class="rslab fw-bold">Register an account</h1>
                            <p class="rslab fs-4">One step away from your academic companion</p>
                            <!-- REGISTRATION FORM -->
                            <form method="POST" action="#" class="py-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="accountFullName" class="rsans form-label fw-semibold">Full name</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user"></i></span>
                                        <input type="text" name="accountFullName" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="accountEmailAddress" class="rsans form-label fw-semibold">E-mail address</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-envelope"></i></span>
                                        <input type="email" name="accountEmailAddress" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="accountPassword" class="rsans form-label fw-semibold">Password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-lock d-flex"></i></span>
                                        <input type="password" name="accountPassword" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="accountPassword_confirmation" class="rsans form-label fw-semibold">Confirm password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-check-circle"></i></span>
                                        <input type="password" name="accountPassword_confirmation" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="accountRole" class="rsans form-label fw-semibold">I am registering as a</label>
                                    <select class="form-select" id="accountRole">
                                        <option selected disabled value="">Choose...</option>
                                        <option>Student</option>
                                        <option>Faculty member</option>
                                        <option>Admin</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a user role.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="accountMatricNumber" class="rsans form-label fw-semibold">Matric number</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-id-badge"></i></span>
                                        <input type="text" name="accountMatricNumber" class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center py-3">
                                    <button type="submit" class="btn btn-primary" style="width: 50%;">Register account</button>
                                </div>
                            </form>
                            <!-- END REGISTRATION FORM -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right section (illustration) -->
            <div class="col-md-6 p-0 d-none d-md-block">
                <img src="{{ asset('images/register_illustration.jpg') }}" alt="Register page illustration" class="img-fluid h-100 w-100 object-fit-cover">
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>

<html>


<!--
BEFORE YOU CONTINUE, 27/8/2024, ADDRESS THE FOLLOWING
    2. Consider increasing the padding on the form.
    3. After addressing the above two, get ready for the beginning of DB integration!
-->
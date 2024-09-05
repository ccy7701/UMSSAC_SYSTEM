<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X_UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    @vite('resources/sass/app.scss')
</head>

<body style="height: 100%; overflow: hidden">
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
                                Change password
                            </h1>
                            <p class="rslab fs-4">Fill in the details below to change your password.</p>
                            <!-- CHANGE PASSWORD FORM -->
                            @if ($errors->any())
                                <br>
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{$error}}
                                    @endforeach
                                </div>
                            @endif
                            <form method="POST" action="{{ route('change-password.action') }}" class="py-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="current-password" class="rsans form-label fw-semibold">Current password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-user-lock d-flex"></i></span>
                                        <input type="password" id="current-password" name="current_password" class="rsans form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new-password" class="rsans form-label fw-semibold">New password (minimum 8 characters)</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-lock d-flex"></i></span>
                                        <input type="password" id="new-password" name="new_account_password" class="rsans form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="new-password-confirmation" class="rsans form-label fw-semibold">Confirm new password</label>
                                    <div class="input-group">
                                        <span class="formfield-span input-group-text d-flex justify-content-center"><i class="fa fa-unlock-keyhole d-flex"></i></span>
                                        <input type="password" id="new-password-confirmation" name="new_account_password_confirmation" class="rsans form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center py-3">
                                    <button type="submit" class="rsans fw-bold btn btn-primary" style="width: 50%;">Change password</button>
                                </div>
                            </form>
                            <!-- END CHANGE PASSWORD FORM -->
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
</body>

</html>

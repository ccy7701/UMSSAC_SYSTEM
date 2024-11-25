<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
    <style>
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
    </style>
</head>

<body style="background-color: #EDF2F7; font-family: 'Arial', sans-serif; color: #2C3E50; margin: 0; padding: 20px;">
    <div class="email-container" style="background-color: #FFFFFF; border-radius: 8px; max-width: 600px; margin: 0 auto; padding: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
        <div class="header" style="text-align: center; margin-bottom: 20px;">
            <img src="https://umssacs.my/images/umssacs_logo_final.png" alt="UMSSACS logo" style="max-width: 35%;">
        </div>

        <h1 style="text-align: center; color: #2C3E50; font-size: 24px; margin-bottom: 10px;">Email Verification</h1>

        <br>

        <p>
            Dear {{ $account->account_full_name }},<br>
            Thank you for registering an account. Please click the button below to verify your email address.
        </p>
        
        <br>

        <p style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="button" style="background-color: #1064D6; color: #FFFFFF; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold;">Verify Email Address</a>
        </p>

        <br>

        <p>
            If you did not create an account, no further action is required.
        </p>

        <div class="footer" style="text-align: center; margin-top: 40px;">
            <p style="font-size: 10px; color: #999999;">This is an automated message from the UMSSACS system.</p>
        </div>
    </div>
</body>

</html>

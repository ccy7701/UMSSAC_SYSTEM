<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <title>Club Creation Request Notification</title>
    <style>
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
    </style>
</head>

<body style="background-color: #EDF2F7; font-family: 'Arial', sans-serif; color: #2C3E50; margin: 0; padding: 20px;">
    <div class="email-container" style="background-color: #FFFFFF; border-radius: 8px; max-width: 600px; margin: 0 auto; padding: 30px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <div class="header" style="text-align: center; margin-bottom: 20px;">
            <img src="https://umssacs.my/images/umssacs_logo_final.png" alt="UMSSACS logo" style="max-width: 25%;">
        </div>
        <h1 style="text-align: center; color: #2C3E50; font-size: 24px; margin-bottom: 10px;">New Club Creation Request</h1>
        <p>Dear Admin,</p>
        <p>You have received a new request from <strong>{{ $requester->account->account_full_name }}</strong> to create a new club.</p>
        <p>Here are some quick details about the request:</p>
        <ul>
            <li>Proposed Club Name: <strong>{{ $clubCreationRequest->club_name }}</strong></li>
            <li>Club Category: <strong>{{ $clubCreationRequest->club_category }}</strong></li>
            <li>Requester's Email: <strong>{{ $requester->account->account_email_address }}</strong></li>
            @if (!empty($requester->account->account_contact_number))
                <li>Contact Number: <strong>{{ $requester->account->account_contact_number }}</strong></li>
            @endif
        </ul>
        <p>Please click the button below to view the full details of this request:</p>
        <p style="text-align: center;">
            {{-- <a href="{{ route('admin.clubRequests.show', ['id' => $clubCreationRequest->id]) }}" class="button">View Request</a> --}}
            <a href="http://192.168.0.183:8000/my-profile" class="button" style="background-color: #1064D6; color: #FFFFFF; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold;">View Request</a>
        </p>
        <div class="footer" style="text-align: center; margin-top: 30px; font-size: 12px; color: #999999;">
            <p>This is an automated message from the UMSSACS system.</p>
        </div>
    </div>
</body>

</html>

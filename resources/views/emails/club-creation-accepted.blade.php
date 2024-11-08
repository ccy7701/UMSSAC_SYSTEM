<!DOCTYPE HTML>
<html lang="en" xml:lang="en">

<head>
    <meta charset="UTF-8">
    <title>Club Creation Acceptance Notification</title>
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
    
        <h1 style="text-align: center; color: #2C3E50; font-size: 24px; margin-bottom: 10px;">Club Creation Request Accepted</h1>
    
        <br>

        <p>
            Dear <strong>{{ $requester->account->account_full_name }}</strong>,<br>
            We are pleased to inform you that your request to create the club <strong>{{ $club->club_name }}</strong> has been approved!
        </p>
    
        <br>
    
        <p>Here are the details of your new club:</p>
    
        <ul style="font-size: 16px;">
            <li>Club Name: <strong>{{ $club->club_name }}</strong></li>
            <li>Club Category: <strong>{{ $club->club_category }}</strong></li>
            <li>Club Created On: <strong>{{ \Carbon\Carbon::parse($club->created_at)->format('Y-m-d H:i A') }}</strong></li>
        </ul>
    
        <br>
    
        <p>You can view your club's page by clicking the button below:</p>
    
        <p style="text-align: center;">
            <a href="{{ route('clubs-finder.fetch-club-details', ['club_id' => $club->club_id]) }}" class="button" style="background-color: #1064D6; color: #FFFFFF; text-decoration: none; padding: 12px 20px; border-radius: 5px; font-weight: bold;">View Club</a>
        </p>
    
        <div class="footer" style="text-align: center; margin-top: 40px;">
            <p style="font-size: 10px; color: #999999;">This is an automated message from the UMSSACS system.</p>
        </div>
    </div>
</body>

</html>

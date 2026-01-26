<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <p>Hi {{ $email }},</p>

    <p>We received a request to reset the password for your account. To help you regain access, we’ve generated a temporary password for you.</p>

    <p>Your new password:</p>
    <p><b>{{ $password }}</b></p>

    <p>Thank you for using LTMPS System!</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Credentials</title>
</head>
<body>
    <h1>Welcome to the FYP System</h1>
    <p>Hello {{ $user->UserName }},</p>
    <p>Your account has been created with the following credentials:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->Email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Please change your password upon logging in for the first time.</p>
    <p>Thank you!</p>
</body>
</html>

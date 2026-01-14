<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
            height: auto;
        }

        h1 {
            color: #333;
            text-align: center;
            font-size: 24px;
        }

        p {
            color: #666;
            line-height: 1.6;
            margin: 15px 0;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            margin: 20px 0;
            background-color: #007bff;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .button-container {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 12px;
            text-align: center;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="logo">
            <h2 style="color: #007bff;">FYP-GATE</h2>
        </div>

        <h1>Password Reset Request</h1>

        <p>Hello,</p>

        <p>We received a request to reset the password for your FYP-GATE account associated with
            <strong>{{ $email }}</strong>.</p>

        <p>Click the button below to reset your password:</p>

        <div class="button-container">
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </div>

        <p>Or copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #007bff;">{{ $resetUrl }}</p>

        <div class="warning">
            <strong>⚠️ Security Notice:</strong> This password reset link will expire in 60 minutes.
        </div>

        <p>If you did not request a password reset, please ignore this email. Your password will remain unchanged.</p>

        <div class="footer">
            <p>&copy; 2026 FYP-GATE System. All rights reserved.</p>
            <p>This is an automated email. Please do not reply to this message.</p>
        </div>
    </div>
</body>

</html>

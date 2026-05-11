<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-top: 4px solid #FF4D30; }
        .header { background: #111; padding: 32px; }
        .header h1 { color: #FF4D30; font-size: 24px; font-weight: 900; margin: 0; letter-spacing: -1px; }
        .body { padding: 40px 32px; }
        .message { font-size: 15px; color: #555; line-height: 1.6; margin: 16px 0; }
        .btn { display: inline-block; background: #FF4D30; color: #fff; padding: 14px 32px; font-weight: 800; text-decoration: none; text-transform: uppercase; font-size: 13px; letter-spacing: 1px; margin: 24px 0; border: 2px solid #FF4D30; }
        .btn:hover { background: transparent; color: #FF4D30; }
        .link-fallback { font-size: 12px; color: #999; word-break: break-all; margin-top: 16px; }
        .expiry { font-size: 13px; color: #f87171; font-weight: 700; margin-top: 16px; }
        .footer { background: #f4f4f4; padding: 20px 32px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Challora Recruitment</h1>
        </div>
        <div class="body">
            <p class="message">Hi <strong>{{ $user->name }}</strong>,</p>
            <p class="message">We received a request to reset the password for your Challora account. Click the button below to set a new password:</p>

            <a href="{{ $resetLink }}" class="btn">Reset My Password</a>

            <p class="expiry">⚠ This link expires in 60 minutes.</p>

            <p class="message">If you didn't request a password reset, you can safely ignore this email — your password will remain unchanged.</p>

            <p class="link-fallback">
                If the button doesn't work, copy and paste this link into your browser:<br>
                {{ $resetLink }}
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Challora Recruitment · Built for the future of work.
        </div>
    </div>
</body>
</html>

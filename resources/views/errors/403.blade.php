<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied — Challora</title>
    <link rel="icon" type="image/png" href="/web-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=JetBrains+Mono:wght@700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: #0a0a0a;
            color: #fff;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }
        .logo {
            width: 64px; height: 64px;
            border: 4px solid #FF4D30;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; font-weight: 900; color: #FF4D30;
            margin-bottom: 48px;
        }
        .status-pill {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,77,48,0.1); border: 1px solid #FF4D30;
            color: #FF4D30; font-family: 'JetBrains Mono', monospace;
            font-size: 11px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.1em; padding: 6px 14px;
            border-radius: 999px; margin-bottom: 32px;
        }
        h1 {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 900; letter-spacing: -0.04em;
            line-height: 1; text-align: center; margin-bottom: 20px;
        }
        p {
            font-size: 1.1rem; font-weight: 600; color: #888;
            text-align: center; max-width: 480px;
            line-height: 1.6; margin-bottom: 16px;
        }
        .message-box {
            background: rgba(255,77,48,0.08);
            border: 2px solid #FF4D30;
            padding: 20px 28px;
            max-width: 480px;
            margin-bottom: 48px;
        }
        .message-box p {
            font-size: 0.95rem;
            color: #ccc;
            margin-bottom: 0;
        }
        .btn-row {
            display: flex; gap: 16px; flex-wrap: wrap; justify-content: center;
        }
        .btn {
            display: inline-flex; align-items: center; gap: 10px;
            background: #FF4D30; color: #fff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 16px 32px; text-decoration: none;
            border: 2px solid #FF4D30; transition: all 0.2s;
        }
        .btn:hover { background: transparent; color: #FF4D30; }
        .btn-outline {
            background: transparent; color: #FF4D30; border-color: #FF4D30;
        }
        .btn-outline:hover { background: #FF4D30; color: #fff; }
        .wordmark {
            position: fixed; bottom: -0.1em; left: 0; width: 100%;
            font-size: 18vw; font-weight: 900; text-align: center;
            letter-spacing: -0.04em; color: #1a1a1a;
            line-height: 1; pointer-events: none; user-select: none; overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="logo">C</div>

    <div class="status-pill">
        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.83L6.232 5.43a1.75 1.75 0 00-2.464 0L1.366 15.34c-.77 1.163.192 2.83 1.732 2.83z"/>
        </svg>
        Access Denied
    </div>

    <h1>403</h1>

    <p>You don't have permission to access this page.</p>

    <div class="message-box">
        <p>This area is restricted to authorized personnel only. If you believe this is an error, please contact your administrator or return to the homepage.</p>
    </div>

    <div class="btn-row">
        <a href="/" class="btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/>
            </svg>
            Go to Homepage
        </a>
        <a href="{{ session()->previousUrl() ?? '/' }}" class="btn btn-outline">
            ← Go Back
        </a>
    </div>

    <div class="wordmark">CHALLORA</div>
</body>
</html>
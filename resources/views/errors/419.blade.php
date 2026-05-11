<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challora — Page Expired</title>
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
            width: 64px;
            height: 64px;
            border: 4px solid #FF4D30;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 900;
            color: #FF4D30;
            margin-bottom: 48px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,77,48,0.1);
            border: 1px solid #FF4D30;
            color: #FF4D30;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 6px 14px;
            border-radius: 999px;
            margin-bottom: 32px;
        }

        h1 {
            font-size: clamp(2.5rem, 8vw, 5rem);
            font-weight: 900;
            letter-spacing: -0.04em;
            line-height: 1;
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            font-weight: 600;
            color: #888;
            text-align: center;
            max-width: 480px;
            line-height: 1.6;
            margin-bottom: 48px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #FF4D30;
            color: #fff;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 16px 32px;
            text-decoration: none;
            border: 2px solid #FF4D30;
            transition: all 0.2s;
            margin: 0 8px 16px;
        }

        .btn:hover {
            background: transparent;
            color: #FF4D30;
        }

        .btn-secondary {
            background: transparent;
            color: #888;
            border-color: #333;
        }

        .btn-secondary:hover {
            color: #fff;
            border-color: #fff;
        }

        .wordmark {
            position: fixed;
            bottom: -0.1em;
            left: 0;
            width: 100%;
            font-size: 18vw;
            font-weight: 900;
            text-align: center;
            letter-spacing: -0.04em;
            color: #1a1a1a;
            line-height: 1;
            pointer-events: none;
            user-select: none;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="logo">C</div>

    <div class="status-pill">
        419 — Page Expired
    </div>

    <h1>Session expired.</h1>

    <p>
        Your session has timed out or the page token has expired.
        This usually happens after a long period of inactivity or after a server redeploy.
    </p>

    <div style="display:flex;flex-wrap:wrap;justify-content:center;">
        <a href="javascript:history.back()" class="btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Go Back
        </a>
        <a href="/" class="btn btn-secondary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path d="M3 12l9-9 9 9M5 10v10h5v-6h4v6h5V10"/>
            </svg>
            Homepage
        </a>
    </div>

    <div class="wordmark">CHALLORA</div>
</body>
</html>

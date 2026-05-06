<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Inter', Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background: #fff; border-top: 4px solid #FF4500; }
        .header { background: #111; padding: 32px; }
        .header h1 { color: #FF4500; font-size: 24px; font-weight: 900; margin: 0; letter-spacing: -1px; }
        .body { padding: 40px 32px; }
        .status-badge { display: inline-block; padding: 8px 20px; font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin: 16px 0; }
        .status-accepted { background: #4ade80; color: #000; }
        .status-rejected { background: #f87171; color: #000; }
        .status-reviewed { background: #60a5fa; color: #000; }
        .status-pending  { background: #fbbf24; color: #000; }
        .job-title { font-size: 20px; font-weight: 800; color: #111; margin-bottom: 8px; }
        .message { font-size: 15px; color: #555; line-height: 1.6; margin: 24px 0; }
        .footer { background: #f4f4f4; padding: 20px 32px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Challora Recruitment</h1>
        </div>
        <div class="body">
            <p style="color:#555; font-size:15px;">Hi <strong>{{ $application->user->name }}</strong>,</p>
            <p class="message">Your application for the following position has been updated:</p>
            <div class="job-title">{{ $application->job->title }}</div>
            <div class="status-badge status-{{ $application->status->value }}">
                {{ ucfirst($application->status->value) }}
            </div>
            @php $status = $application->status->value; @endphp
            @if($status === 'accepted')
                <p class="message">Congratulations! 🎉 You have been <strong>accepted</strong> for this position. Our HR team will reach out to you shortly with next steps.</p>
            @elseif($status === 'rejected')
                <p class="message">Thank you for your interest. Unfortunately, we will not be moving forward with your application at this time. We encourage you to apply for future openings.</p>
            @elseif($status === 'reviewed')
                <p class="message">Your application is currently being <strong>reviewed</strong> by our HR team. We will update you once a decision has been made.</p>
            @else
                <p class="message">Your application status has been updated. Please log in to your account for more details.</p>
            @endif
            <p class="message" style="margin-top:32px;">
                <a href="{{ config('app.url') }}/user/applications" style="background:#FF4500;color:#fff;padding:12px 28px;font-weight:800;text-decoration:none;text-transform:uppercase;font-size:13px;">
                    View My Applications
                </a>
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Challora Recruitment · Built for the future of work.
        </div>
    </div>
</body>
</html>

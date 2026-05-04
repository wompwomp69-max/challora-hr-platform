<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Lamaran</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f7fb; padding:24px; color:#111827;">
    <div style="max-width:640px; margin:0 auto; background:#ffffff; border:1px solid #e5e7eb; padding:24px;">
        <h2 style="margin:0 0 16px;">Update Status Lamaran</h2>
        <p style="margin:0 0 12px;">Halo <strong>{{ $candidateName }}</strong>,</p>
        <p style="margin:0 0 12px;">Lamaran Anda untuk posisi <strong>{{ $jobTitle }}</strong> telah diperbarui.</p>
        <p style="margin:0 0 16px;">Status saat ini: <strong>{{ $statusText }}</strong></p>
        <p style="margin:0 0 20px;">{{ $messageText }}</p>
        <p style="margin:0;">Terima kasih,<br><strong>Tim HR Challora</strong></p>
    </div>
</body>
</html>

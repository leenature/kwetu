<!DOCTYPE html>
<html lang="en">
<body style="margin:0;background:#f8fafc;font-family:Arial,sans-serif;color:#0f172a;">
    <div style="max-width:600px;margin:32px auto;padding:32px;background:#fff;border-radius:16px;">
        <h1 style="margin-top:0;color:#1d4ed8;">Welcome to Kwetu</h1>
        <p>Hello {{ $user->name }},</p>
        <p>Your account has been created. Use the credentials below to sign in.</p>
        <div style="padding:18px;background:#eff6ff;border-radius:10px;">
            <p style="margin:0 0 8px;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin:0;"><strong>Initial password:</strong> {{ $initialPassword }}</p>
        </div>
        <p style="margin-top:24px;"><a href="{{ route('login') }}" style="display:inline-block;background:#2563eb;color:#fff;padding:12px 18px;border-radius:8px;text-decoration:none;font-weight:bold;">Log in to Kwetu</a></p>
        <p style="font-size:13px;color:#64748b;">For security, change this password after your first sign-in.</p>
    </div>
</body>
</html>

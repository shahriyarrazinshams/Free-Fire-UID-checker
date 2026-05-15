<?php
/*
 * Free Fire Nickname Proxy API
 * Stable & Fast for Android WebView
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

// UID চেক করা
if (!isset($_GET['uid']) || empty($_GET['uid'])) {
    echo json_encode(["success" => false, "message" => "UID is required"]);
    exit;
}

$uid = htmlspecialchars($_GET['uid']);
$targetUrl = "https://apis.rrrtopup.com/api/v1/player-nickname?id=" . $uid . "&product_id=21";

// cURL ব্যবহার করে ডাটা ফেচ করা (সবচেয়ে স্ট্যাবল মেথড)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $targetUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // ১০ সেকেন্ড টাইমআউট
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/91.0.4472.124 Safari/5.37.36');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo json_encode(["success" => false, "message" => "Connection Timeout"]);
} else {
    if ($httpCode == 200) {
        echo $response;
    } else {
        echo json_encode(["success" => false, "message" => "Server Error: " . $httpCode]);
    }
}

curl_close($ch);
?>

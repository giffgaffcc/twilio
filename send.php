<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

if (($_SESSION[SESSION_KEY] ?? '') !== 'ok') {
    echo json_encode(['ok'=>false,'msg'=>'未登录']); exit;
}

$to   = trim($_POST['to']   ?? '');
$body = trim($_POST['body'] ?? '');
if (!$to || !$body) {
    echo json_encode(['ok'=>false,'msg'=>'收件号码和内容不能为空']); exit;
}

$sid   = TWILIO_ACCOUNT_SID;
$token = TWILIO_AUTH_TOKEN;
$from  = TWILIO_PHONE_NUMBER;
$url   = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query(['To'=>$to,'From'=>$from,'Body'=>$body]),
    CURLOPT_USERPWD        => "{$sid}:{$token}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true,
]);
$result = curl_exec($ch);
$err    = curl_error($ch);
curl_close($ch);

if ($err) { echo json_encode(['ok'=>false,'msg'=>'cURL错误:'.$err]); exit; }

$resp = json_decode($result, true);
if (!empty($resp['sid'])) {
    $db   = new PDO('sqlite:' . DB_PATH);
    $stmt = $db->prepare("
        INSERT INTO messages (direction, from_number, to_number, body, status, sid)
        VALUES ('outbound', :from, :to, :body, :status, :sid)
    ");
    $stmt->execute([':from'=>$from,':to'=>$to,':body'=>$body,
                    ':status'=>$resp['status']??'queued',':sid'=>$resp['sid']]);
    echo json_encode(['ok'=>true,'sid'=>$resp['sid']]);
} else {
    echo json_encode(['ok'=>false,'msg'=>$resp['message']??$result]);
}
exit;
?>

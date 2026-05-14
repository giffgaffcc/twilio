<?php
require_once 'config.php';

$from = $_POST['From']       ?? '';
$to   = $_POST['To']         ?? '';
$body = $_POST['Body']       ?? '';
$sid  = $_POST['MessageSid'] ?? '';

if ($from && $body) {
    $db   = new PDO('sqlite:' . DB_PATH);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare("
        INSERT INTO messages (direction, from_number, to_number, body, status, sid)
        VALUES ('inbound', :from, :to, :body, 'received', :sid)
    ");
    $stmt->execute([':from'=>$from,':to'=>$to,':body'=>$body,':sid'=>$sid]);
}

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<Response></Response>';
exit;
?>

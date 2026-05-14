<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

if (($_SESSION[SESSION_KEY] ?? '') !== 'ok') {
    echo json_encode(['ok'=>false,'msg'=>'未登录']); exit;
}

$db     = new PDO('sqlite:' . DB_PATH);
$page   = max(1, (int)($_GET['page']   ?? 1));
$filter = $_GET['filter'] ?? 'all';
$search = trim($_GET['search'] ?? '');
$limit  = 30;
$offset = ($page - 1) * $limit;

$where  = '1=1';
$params = [];
if ($filter === 'inbound')  $where .= " AND direction='inbound'";
if ($filter === 'outbound') $where .= " AND direction='outbound'";
if ($search) {
    $where .= " AND (from_number LIKE :s OR to_number LIKE :s OR body LIKE :s)";
    $params[':s'] = '%'.$search.'%';
}

$total = $db->prepare("SELECT COUNT(*) FROM messages WHERE $where");
$total->execute($params);
$count = (int)$total->fetchColumn();

$stmt = $db->prepare("
    SELECT id,direction,from_number,to_number,body,status,sid,created_at
    FROM messages WHERE $where
    ORDER BY id DESC LIMIT $limit OFFSET $offset
");
$stmt->execute($params);
echo json_encode(['ok'=>true,'total'=>$count,'rows'=>$stmt->fetchAll(PDO::FETCH_ASSOC),'page'=>$page]);
exit;
?>

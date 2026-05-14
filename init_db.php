<?php
require_once 'config.php';
$dir = dirname(DB_PATH);
if (!is_dir($dir)) mkdir($dir, 0755, true);
$db = new PDO('sqlite:' . DB_PATH);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("
    CREATE TABLE IF NOT EXISTS messages (
        id          INTEGER PRIMARY KEY AUTOINCREMENT,
        direction   TEXT NOT NULL,
        from_number TEXT NOT NULL,
        to_number   TEXT NOT NULL,
        body        TEXT NOT NULL,
        status      TEXT DEFAULT 'received',
        sid         TEXT,
        created_at  DATETIME DEFAULT (datetime('now','localtime'))
    )
");
echo "数据库初始化成功！";
?>

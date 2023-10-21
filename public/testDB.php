<?php

$dsn = 'sqlite:' . __DIR__ . '/../database/db.sqlite';

try {
    $db = new PDO($dsn);
} catch (\Throwable $th) {
    echo 'Connection failed: ' . $th->getMessage();
    exit;
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

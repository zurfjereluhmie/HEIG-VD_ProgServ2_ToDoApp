<?php
session_start();

if (!isset($_SESSION["user"])) {
    exit();
}

$req = file_get_contents('php://input');
$req = json_decode($req, true);

if (!isset($req["id"])) {
    exit();
}

if (!is_numeric($req["id"])) {
    exit();
}


require_once '../../../app/autoload.php';

use ch\comem\todoapp\task\TaskManager;

$taskManager = TaskManager::getInstance();
$task = $taskManager->getTask($req["id"]);

if (!$task) {
    exit();
}

$taskManager->removeTask($task);

echo json_encode(["status" => "success"]);

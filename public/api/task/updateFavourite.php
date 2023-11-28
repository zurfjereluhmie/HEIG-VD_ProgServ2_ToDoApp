<?php
session_start();

if (!isset($_SESSION["user"])) {
    exit();
}

$req = file_get_contents('php://input');
$req = json_decode($req, true);

if (!isset($req["id"]) || !isset($req["favourite"])) {
    exit();
}

if (!is_numeric($req["id"]) || !is_bool($req["favourite"])) {
    exit();
}


require_once '../../../app/autoload.php';

use ch\comem\todoapp\task\TaskManager;

$taskManager = TaskManager::getInstance();
$task = $taskManager->getTask($req["id"]);


if (!$task) {
    json_encode(["status" => "error"]);
    exit();
}

$task->setIsFav($req["favourite"]);
$taskManager->updateTask($task);

echo json_encode(["status" => "success"]);

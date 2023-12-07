<?php
session_start();

if (!isset($_SESSION["user"])) {
    exit();
}

$req = file_get_contents('php://input');
$req = json_decode($req, true);
$search = $req["searchValue"];

if (empty($search)) {
    exit();
}

require_once "../../app/autoload.php";

use ch\comem\todoapp\category\CategoryManager;
use ch\comem\todoapp\task\TaskManager;

$categoryManager = CategoryManager::getInstance();
$categories = $categoryManager->getCategoriesByTitle($search);

$taskManager = TaskManager::getInstance();
$tasks = $taskManager->getTasksByTitle($search);
if (empty($tasks)) {
    echo json_encode([]);
    exit();
}

$data = [
    "categories" => [],
    "tasks" => []
];
foreach ($categories as $category) {
    $data["categories"][] = [
        "id" => $category->getId(),
        "title" => $category->getTitle()
    ];
}
foreach ($tasks as $task) {
    $data["tasks"][] = [
        "id" => $task->getId(),
        "title" => $task->getTitle()
    ];
}

echo json_encode($data);

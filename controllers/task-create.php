<?php

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\TaskBuilder;
use ch\comem\todoapp\task\TaskManager;

$taskTitle = htmlspecialchars($_POST['task-title']);
$taskDueDate = filter_input(INPUT_POST, 'task-due-date', FILTER_VALIDATE_REGEXP, [
    "options" => [
        "regexp" => "/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/"
    ]
]);
$taskCategoryId = filter_input(INPUT_POST, 'task-category-select', FILTER_VALIDATE_INT);
$taskDescription = htmlspecialchars($_POST['task-description']) ?? "";

if (!$taskTitle || !$taskDueDate || !$taskCategoryId) {
    new Flash("task-create", TEXT['must-fill-all-fields'], "danger");
    header("Location: /task-create.php");
    exit();
}

$taskDueDate = new DateTime($taskDueDate);

if ($taskDueDate < new DateTime()) {
    new Flash("task-create", TEXT['error-task-due-date'], "danger");
    header("Location: /task-create.php");
    exit();
}

$task = (new TaskBuilder($taskTitle, $taskDueDate, $taskCategoryId))
    ->setDescription($taskDescription)
    ->build();

$taskManager = TaskManager::getInstance();

if ($taskManager->addTask($task)) {
    $id = $task->getCategoryId();
    new Flash("task-create", TEXT['task-create'], "success");
    header("Location: /category.php?id=$id");
} else {
    new Flash("task-create", TEXT['error-while-task-create'], "danger");
    header("Location: /task-create.php");
}

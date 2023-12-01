<?php

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\TaskManager;

$taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);
$taskTitle = htmlspecialchars($_POST['task-title']);
$taskDueDate = htmlspecialchars($_POST['task-due-date']);
$taskCategoryId = htmlspecialchars($_POST['task-category-id']);
$taskDescription = htmlspecialchars($_POST['task-description']) ?? "";

if (!$taskId || !$taskTitle || !$taskDueDate || !$taskCategoryId) {
    new Flash("task-update", TEXT['must-fill-all-fields'], "danger");
    header("Location: /task-update.php?id=$taskId");
    exit();
}

$TaskManager = TaskManager::getInstance();
$task = $TaskManager->getTask($taskId);

if (!$task) {
    new Flash("task-update", TEXT['error-task-not-found'], "danger");
    header("Location: /task-update.php?id=$taskId");
    exit();
}

$taskDueDate = new DateTime($taskDueDate);

$task->setTitle($taskTitle);
$task->setDueDate($taskDueDate);
$task->setCategory($taskCategoryId);
$task->setDescription($taskDescription);

if ($TaskManager->updateTask($task)) {
    $catId = $task->getCategoryId();
    new Flash("global", TEXT['task-update'], "success");
    header("Location: /category.php?id=$catId");
    exit();
} else {
    new Flash("task-update", TEXT['error-task-update'], "danger");
    header("Location: /task-update.php?id=$taskId");
    exit();
}

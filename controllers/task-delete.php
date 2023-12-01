<?php

use ch\comem\todoapp\flash\Flash;
use ch\comem\todoapp\task\TaskManager;

$taskId = filter_input(INPUT_POST, 'taskId', FILTER_SANITIZE_NUMBER_INT);

if (!$taskId) {
    new Flash("task-update", TEXT['error-task-delete'], "danger");
    header("Location: /task-update.php?id=$catId");
    die();
}

$taskManager = TaskManager::getInstance();
$task = $taskManager->getTask($taskId);

if (!$task) {
    new Flash("task-update", TEXT['error-task-not-found'], "danger");
    header("Location: /task-update.php?id=$catId");
    die();
}

if ($taskManager->removeTask($task)) {
    new Flash("global", TEXT['task-delete'], "success");
    header("Location: /categories.php");
    die();
} else {
    new Flash("task-update", TEXT['error-task-delete'], "danger");
    header("Location: /task-update.php?id=$catId");
    die();
}

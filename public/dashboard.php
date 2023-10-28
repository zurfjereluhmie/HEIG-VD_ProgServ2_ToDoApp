<?php
require_once("../app/autoload.php");

use ch\comem\todoapp\Task;
use ch\comem\todoapp\TaskManager;


$task = new Task("Test", "Test", false);

echo $task->getTitle() . "<br>";
echo $task->getDescription() . "<br>";
echo $task->isDone() . "<br>";

$taskManager = TaskManager::getInstance();

$taskManager->add($task);
$taskManager->displayTasks();
$taskManager->add($task);

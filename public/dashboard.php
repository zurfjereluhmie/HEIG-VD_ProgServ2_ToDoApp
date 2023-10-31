<?php
session_start();
require_once("../app/autoload.php");

use ch\comem\todoapp\tasks\Task;
use ch\comem\todoapp\tasks\TaskManager;
use ch\comem\todoapp\auth\User;
use ch\comem\todoapp\dbCRUD\DbManagerCRUD_User;

$database = DbManagerCRUD_User::getInstance();

$user = $database->readUsingEmail("test1@gmail.com");

$user->resetPassword();

echo "<pre>";
print_r($user);
echo "</pre>";



echo "<br>";
echo "<br>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
echo "<br>";
echo "<br>";

try {
    $user = new User("test@gmail.com", "test", "test", "test");
    print_r($user);
    echo "<br>";

    $task = new Task("Test", "Test", false);

    echo $task->getTitle() . "<br>";
    echo $task->getDescription() . "<br>";
    echo $task->isDone() . "<br>";

    $taskManager = TaskManager::getInstance();

    $taskManager->add($task);
    $taskManager->displayTasks();
    $taskManager->add($task);
} catch (Throwable $th) {
    echo "Erreur : " . $th->getMessage();
}

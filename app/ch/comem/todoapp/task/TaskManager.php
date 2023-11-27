<?php

namespace ch\comem\todoapp\task;

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_Task;
use Exception;

/**
 * This class manages tasks for the Todo app.
 * It is a singleton class, meaning that only one instance of this class can exist.
 * 
 * @package ch\comem\todoapp\task
 */
class TaskManager
{
    private static ?TaskManager $instance = null;
    private array $tasks;

    private function __construct()
    {
        $this->tasks = [];
        $this->loadTasks();
    }

    static public function getInstance(): TaskManager
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    public function loadTasks(): bool
    {
        $this->tasks = DbManagerCRUD_Task::getInstance()->readAll();
        return true;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function getTask(int $id): ?Task
    {
        foreach ($this->tasks as $task) {
            if ($task->getId() == $id) return $task;
        }
        return null;
    }

    public function getTasksByCategory(int $categoryId): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if ($task->getCategory()->getId() == $categoryId) $tasks[] = $task;
        }
        return $tasks;
    }

    public function addTask(Task $task): bool
    {
        $dbManager = DbManagerCRUD_Task::getInstance();
        $id = $dbManager->create($task);
        if (!$id) throw new Exception("Error while creating task");

        $task = $dbManager->read($id);

        if (!$task) throw new Exception("Error while reading task");

        $this->tasks[] = $task;
        return true;
    }

    public function updateTask(Task $task): bool
    {
        if ($task->getId() == null) throw new Exception("Cannot update task without ID");

        $dbManager = DbManagerCRUD_Task::getInstance();
        $res = $dbManager->update($task->getId(), $task);
        if (!$res) throw new Exception("Error while updating task");

        if ($res instanceof Task) {
            $this->loadTasks();
            return true;
        }
        return false;
    }

    public function removeTask(Task $task): bool
    {
        if ($task->getId() == null) throw new Exception("Cannot remove task without ID");

        $dbManager = DbManagerCRUD_Task::getInstance();
        $res = $dbManager->delete($task->getId());
        if (!$res) throw new Exception("Error while removing task");

        $this->loadTasks();
        return true;
    }
}

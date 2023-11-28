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

    /**
     * Returns an instance of the TaskManager class.
     *
     * @return TaskManager The instance of the TaskManager class.
     */
    static public function getInstance(): TaskManager
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    /**
     * Loads the tasks.
     *
     * @return bool Returns true if the tasks were successfully loaded, false otherwise.
     */
    private function loadTasks(): bool
    {
        $this->tasks = DbManagerCRUD_Task::getInstance()->readAll();
        return true;
    }

    /**
     * Retrieves an array of tasks.
     *
     * @return array The array of tasks.
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * Retrieves a task by its ID.
     *
     * @param int $id The ID of the task to retrieve.
     * @return Task|null The task object if found, null otherwise.
     */
    public function getTask(int $id): ?Task
    {
        foreach ($this->tasks as $task) {
            if ($task->getId() == $id) return $task;
        }
        return null;
    }

    // TODO : Tester cette fonction
    /**
     * Retrieves tasks by category ID.
     *
     * @param int $categoryId The ID of the category.
     * @return array An array of tasks.
     */
    public function getTasksByCategory(int $categoryId): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if ($task->getCategory()->getId() == $categoryId) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Retrieves an array of tasks with the given title.
     *
     * @param string $title The title of the tasks to retrieve.
     * @return array An array of tasks with the given title.
     */
    public function getTasksByTitle(string $title): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if (strpos($task->getTitle(), $title)) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Adds a task to the task manager.
     *
     * @param Task $task The task to be added.
     * @return bool Returns true if the task was successfully added, false otherwise.
     */
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

    /**
     * Updates a task.
     *
     * @param Task $task The task to update.
     * @return bool Returns true if the task was successfully updated, false otherwise.
     */
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

    /**
     * Removes a task from the task manager.
     *
     * @param Task $task The task to be removed.
     * @return bool Returns true if the task was successfully removed, false otherwise.
     */
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

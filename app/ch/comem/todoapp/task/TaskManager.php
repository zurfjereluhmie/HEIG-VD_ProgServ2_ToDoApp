<?php

namespace ch\comem\todoapp\task;

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_Task;
use ch\comem\todoapp\category\CategoryManager;
use Exception;
use DateTime;

/**
 * This class manages tasks for the Todo app.
 * It is a singleton class
 * 
 * @package ch\comem\todoapp\task
 */
class TaskManager
{
    /**
     * @var TaskManager|null $instance The singleton instance of the TaskManager.
     */
    private static ?TaskManager $instance = null;
    /**
     * @var array<Task> $tasks An array to store tasks.
     */
    private array $tasks = [];

    /**
     * Private constructor for the TaskManager class.
     */
    private function __construct()
    {
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
    public function loadTasks(): bool
    {
        $this->tasks = DbManagerCRUD_Task::getInstance()->readAll();
        return true;
    }

    /**
     * Returns an array of tasks.
     *
     * @return array The array of tasks.
     */
    public function getTasks(): array
    {
        $this->loadTasks();
        return $this->tasks;
    }

    /**
     * Returns a task by its ID.
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

    /**
     * Returns tasks by category ID.
     *
     * @param int $categoryId The ID of the category.
     * @return array<Task> An array of tasks.
     */
    public function getTasksByCategory(int $categoryId): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if (!$task instanceof Task) throw new Exception("Task is not a Task object");
            if ($task->getCategoryId() == $categoryId) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Returns an array of tasks with the given title.
     *
     * @param string $title The title of the tasks to retrieve.
     * @return array<Task> An array of tasks with the given title.
     */
    public function getTasksByTitle(string $title): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if (str_contains(strtoupper($task->getTitle()), strtoupper($title))) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Returns an array of late tasks.
     *
     * @return array<Task> The array of late tasks.
     */
    public function getLateTasks(): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if ($task->isDone()) continue;
            if (strtotime($task->getDueDate()->format("Y-m-d")) < strtotime(date("Y-m-d"))) $tasks[] = $task;
            else if (strtotime($task->getDueDate()->format("Y-m-d")) == strtotime(date("Y-m-d")) && strtotime($task->getDueDate()->format("H:i:s")) < strtotime(date("H:i:s"))) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Returns an array of done tasks.
     *
     * @return array<Task> The array of done tasks.
     */
    public function getDoneTasks(): array
    {
        $tasks = [];
        foreach ($this->tasks as $task) {
            if ($task->isDone()) $tasks[] = $task;
        }
        return $tasks;
    }

    /**
     * Returns the actual tasks.
     * Actual tasks are tasks that are not late and not done.
     *
     * @return array<Task> The array of actual tasks.
     */
    public function getActualTasks(): array
    {
        $tasks = [];
        $taskToExclude = array_merge($this->getLateTasks(), $this->getDoneTasks());
        foreach ($this->tasks as $task) {
            if (!in_array($task, $taskToExclude)) $tasks[] = $task;
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
        $categoryManager = CategoryManager::getInstance();
        if (!$categoryManager->getCategory($task->getCategoryId())) throw new Exception("Category does not exist");

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
        if ($task->getDueDate() < new DateTime()) throw new Exception("Cannot update task with due date in the past");

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
     * Removes a task from the task manager and the database.
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

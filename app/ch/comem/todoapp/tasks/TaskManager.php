<?php

namespace ch\comem\todoapp\tasks;

use Exception;

/**
 * This class manages tasks for the Todo app.
 * It is a singleton class, meaning that only one instance of this class can exist.
 * 
 * @package ch\comem\todoapp\tasks
 */
class TaskManager
{
    /**
     * This is a static private variable that holds an instance of the TaskManager class.
     * @var TaskManager $instance
     */
    static private $instance = null;
    /**
     * @var Task[] $tasks An array of tasks managed by the TaskManager
     */
    private $tasks = [];

    /**
     * Constructor for the TaskManager class.
     * This method is private to ensure that only one instance of the TaskManager can be created.
     * @access private
     */
    private function __construct()
    {
        $this->tasks = [];
        $this->initTasks();
    }

    /**
     * Returns an instance of the TaskManager class.
     *
     * @return TaskManager
     */
    static public function getInstance(): TaskManager
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    /**
     * Adds a task to the task manager.
     *
     * @param Task $task The task to add.
     * @return void
     */
    public function add(Task $task): void
    {
        if (!$task instanceof Task) throw new Exception("Task must be of type Task");
        if (in_array($task, $this->tasks)) throw new Exception("Task already exists");
        $this->tasks[] = $task;
    }

    /**
     * Displays the tasks.
     *
     * @return void
     */
    public function displayTasks(): void
    {
        foreach ($this->tasks as $task) {
            echo $task->getTitle() . "<br>";
            echo $task->getDescription() . "<br>";
            echo $task->isDone() . "<br>";
        }
    }

    /**
     * Initializes the tasks.
     * @return void
     */
    private function initTasks(): void
    {
        echo "initTasks() called<br>";
        $this->tasks[] = new Task("Test", "Test", false);
        $this->tasks[] = new Task("Test2", "Test2", false);
        $this->tasks[] = new Task("Test3", "Test3", false);
    }
}

<?php

namespace ch\comem\todoapp;

use Exception;

class TaskManager
{
    static private $instance = null;
    private $tasks = [];

    private function __construct()
    {
        $this->tasks = [];
        $this->initTasks();
    }

    static public function getInstance(): TaskManager
    {
        if (is_null(self::$instance)) self::$instance = new self();
        return self::$instance;
    }

    public function add(Task $task): void
    {
        if (!$task instanceof Task) throw new Exception("Task must be of type Task");
        if (in_array($task, $this->tasks)) throw new Exception("Task already exists");
        $this->tasks[] = $task;
    }

    public function displayTasks(): void
    {
        foreach ($this->tasks as $task) {
            echo $task->getTitle() . "<br>";
            echo $task->getDescription() . "<br>";
            echo $task->isDone() . "<br>";
        }
    }

    private function initTasks(): void
    {
        echo "initTasks() called<br>";
        $this->tasks[] = new Task("Test", "Test", false);
        $this->tasks[] = new Task("Test2", "Test2", false);
        $this->tasks[] = new Task("Test3", "Test3", false);
    }
}

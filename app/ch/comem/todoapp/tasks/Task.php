<?php

namespace ch\comem\todoapp\tasks;

use Exception;

/**
 * Represents a task in the Todo app.
 * 
 * @package ch\comem\todoapp\tasks
 */
final class Task
{
    /**
     * @var int $counter A static counter used to keep track of the number of tasks created.
     */
    static private $counter = 0;
    /**
     * @var int $id The unique identifier of the task.
     */
    private $id;
    /**
     * @var string $title The title of the task.
     */
    private $title;
    /**
     * @var string $description The description of the task.
     */
    private $description;
    /**
     * @var bool $isDone Indicates whether the task is done or not.
     */
    private $isDone;

    /**
     * Task constructor.
     * @param string $title The title of the task.
     * @param string $description The description of the task.
     * @param bool $isDone The status of the task (done or not).
     */
    public function __construct($title, $description, $isDone)
    {
        if (!$title || !is_string($title)) throw new Exception('Title must be defined and of type string');
        if (!$description || !is_string($description)) throw new Exception('Description must be defined and of type string');

        // Those values should be later replaced with values from the database
        $this->id = ++self::$counter;
        $this->title = $title;
        $this->description = $description;
        $this->isDone = $isDone;
    }

    /**
     * Get the ID of the task.
     *
     * @return int The ID of the task.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Returns the title of the task.
     *
     * @return string The title of the task.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the description of the task.
     *
     * @return string The description of the task.
     */
    public function getDescription(): string

    {
        return $this->description;
    }

    /**
     * Determines whether the task is done or not.
     *
     * @return bool True if the task is done, false otherwise.
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }
}

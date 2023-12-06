<?php

namespace ch\comem\todoapp\task;

use DateTime;
use Exception;

/**
 * This class is responsible for building Task objects.
 * 
 * @package ch\comem\todoapp\task
 */
class TaskBuilder
{
    /**
     * @var int|null $id The ID of the task.
     */
    private ?int $id;
    /**
     * @var string $title The title of the task.
     */
    private string $title;
    /**
     * @var string|null $description The description of the task.
     */
    private ?string $description;
    /**
     * @var bool $isDone Indicates whether the task is done or not.
     */
    private bool $isDone;
    /**
     * @var bool $isFav Indicates whether the task is marked as favorite or not.
     */
    private bool $isFav;
    /**
     * @var DateTime $dueDate The due date of the task.
     */
    private DateTime $dueDate;
    /**
     * @var int $categoryId The ID of the category associated with the task.
     */
    private int $categoryId;

    /**
     * TaskBuilder constructor.
     *
     * @param string $title The title of the task.
     * @param DateTime $dueDate The due date of the task.
     * @param int $categoryId The ID of the category the task belongs to.
     */
    public function __construct(string $title, DateTime $dueDate, int $categoryId)
    {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        if (!isset($dueDate) || empty($dueDate)) throw new Exception("Due date cannot be empty");
        if (!isset($categoryId) || empty($categoryId)) throw new Exception("Category ID cannot be empty");

        $this->id = null;
        $this->title = $title;
        $this->description = null;
        $this->isDone = false;
        $this->isFav = false;
        $this->dueDate = $dueDate;
        $this->categoryId = $categoryId;
    }

    /**
     * Returns the ID of the task.
     *
     * @return int|null The ID of the task, or null if it doesn't have an ID.
     */
    public function getId(): ?int
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
     * @return string|null The description of the task, or null if no description is set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Returns if the task is done or not.
     *
     * @return bool Returns true if the task is done, false otherwise.
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * Returns if the task is marked as favorite or not.
     *
     * @return bool Returns true if the task is marked as favorite, false otherwise.
     */
    public function isFav(): bool
    {
        return $this->isFav;
    }

    /**
     * Returns the due date of the task.
     *
     * @return DateTime The due date of the task.
     */
    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    /**
     * Returns the category ID of the task.
     *
     * @return int The category ID.
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * Builds a Task object.
     *
     * @return Task The built Task object.
     */
    public function build(): Task
    {
        return new Task($this);
    }

    /**
     * Sets the ID of the task.
     *
     * @param int $id The ID of the task.
     * @return TaskBuilder The updated TaskBuilder instance.
     */
    public function setId(int $id): TaskBuilder
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Sets the description of the task.
     *
     * @param string|null $description The description of the task.
     * @return TaskBuilder The TaskBuilder instance.
     */
    public function setDescription(?string $description): TaskBuilder
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Sets the value of isDone.
     *
     * @param bool $isDone The new value of isDone.
     * @return TaskBuilder The current instance of TaskBuilder.
     */
    public function setIsDone(bool $isDone): TaskBuilder
    {
        $this->isDone = $isDone;
        return $this;
    }

    /**
     * Sets the favorite status of the task.
     *
     * @param bool $isFav The favorite status of the task.
     * @return TaskBuilder The TaskBuilder instance.
     */
    public function setIsFav(bool $isFav): TaskBuilder
    {
        $this->isFav = $isFav;
        return $this;
    }
}

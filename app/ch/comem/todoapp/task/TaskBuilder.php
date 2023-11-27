<?php

namespace ch\comem\todoapp\task;

use ch\comem\todoapp\category\Category;
use ch\comem\todoapp\category\CategoryManager;
use DateTime;
use Exception;

/**
 * Class TaskBuilder
 * 
 * This class is responsible for building Task objects.
 * 
 * @package ch\comem\todoapp\task
 */
class TaskBuilder
{
    private ?int $id;
    private string $title;
    private ?string $description;
    private bool $isDone;
    private bool $isFav;
    private DateTime $dueDate;
    private Category $category;

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
        $this->category = CategoryManager::getInstance()->getCategory($categoryId);
    }

    /**
     * Get the ID of the task.
     *
     * @return int|null The ID of the task, or null if it doesn't have an ID.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the title of the task.
     *
     * @return string The title of the task.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the description of the task.
     *
     * @return string|null The description of the task, or null if no description is set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Check if the task is done.
     *
     * @return bool Returns true if the task is done, false otherwise.
     */
    public function isDone(): bool
    {
        return $this->isDone;
    }

    /**
     * Check if the task is marked as favorite.
     *
     * @return bool Returns true if the task is marked as favorite, false otherwise.
     */
    public function isFav(): bool
    {
        return $this->isFav;
    }

    /**
     * Get the due date of the task.
     *
     * @return DateTime The due date of the task.
     */
    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    /**
     * Get the category of the task.
     *
     * @return Category The category of the task.
     */
    public function getCategory(): Category
    {
        return $this->category;
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
     * Set the ID of the task.
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
     * Set the description of the task.
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
     * Set the value of isDone.
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
     * Set the favorite status of the task.
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

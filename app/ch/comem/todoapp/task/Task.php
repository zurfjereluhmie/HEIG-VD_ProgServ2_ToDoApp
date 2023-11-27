<?php

namespace ch\comem\todoapp\task;

use Exception;
use DateTime;
use ch\comem\todoapp\task\TaskBuilder;
use ch\comem\todoapp\category\Category;

/**
 * Represents a task in the Todo app.
 * 
 * @package ch\comem\todoapp\task
 */
class Task
{
    private ?int $id;
    private string $title;
    private ?string $description;
    private bool $isDone;
    private bool $isFav;
    private DateTime $dueDate;
    private Category $category;

    /**
     * Task constructor.
     *
     * @param TaskBuilder $builder The task builder object used to construct the task.
     */
    public function __construct(TaskBuilder $builder)
    {
        $this->id = $builder->getId();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->isDone = $builder->isDone();
        $this->isFav = $builder->isFav();
        $this->dueDate = $builder->getDueDate();
        $this->category = $builder->getCategory();
    }

    /**
     * Get the ID of the task.
     *
     * @return int The ID of the task.
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
     * @return string The description of the task.
     */
    public function getDescription(): ?string
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

    /**
     * Determines whether the task is a favorite or not.
     *
     * @return bool True if the task is a favorite, false otherwise.
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
     * Returns the category of the task.
     *
     * @return Category The category of the task.
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Sets the title of the task.
     *
     * @param string $title The title of the task.
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Sets the description of the task.
     * 
     * @param string $description The description of the task.
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Sets whether the task is done or not.
     *
     * @param bool $isDone True if the task is done, false otherwise.
     */
    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    /**
     * Sets whether the task is a favorite or not.
     *
     * @param bool $isFav True if the task is a favorite, false otherwise.
     */
    public function setIsFav(bool $isFav): void
    {
        $this->isFav = $isFav;
    }

    /**
     * Sets the due date of the task.
     *
     * @param DateTime $dueDate The due date of the task.
     */
    public function setDueDate(DateTime $dueDate): void
    {
        if ($dueDate < new DateTime()) throw new Exception("Due date cannot be in the past");
        $this->dueDate = $dueDate;
    }

    /**
     * Sets the category of the task.
     * 
     * @param Category $category The category of the task.
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }
}

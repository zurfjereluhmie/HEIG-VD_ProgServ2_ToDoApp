<?php

namespace ch\comem\todoapp\category;

use Exception;
use DateTime;
use ch\comem\todoapp\category\CategoryBuilder;

/**
 * Represents a category in the Todo app.
 * 
 * @package ch\comem\todoapp\category
 */
class Category
{
    /**
     * @var int|null $id The ID of the category (nullable)
     */
    private ?int $id;
    /**
     * @var string $title The title of the category.
     */
    private string $title;
    /**
     * @var string|null $description The description of the category (nullable)
     */
    private ?string $description;
    /**
     * @property string $color The color of the category.
     */
    private string $color;

    private DateTime $createdAt;

    /**
     * @var array $tasks An array of tasks associated with this category.
     */
    private array $tasks;

    public function __construct(CategoryBuilder $builder)
    {
        $this->id = $builder->getId();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->color = $builder->getColor();
        $this->createdAt = $builder->getCreatedAt();
        $this->tasks = $builder->getTasks();
    }

    /**
     * Returns the ID of the category.
     *
     * @return int|null The ID of the category or null if it doesn't exist.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the title of the category.
     *
     * @return string The title of the category.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the description of the category.
     *
     * @return string|null The description of the category, or null if it doesn't have one.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Returns the color of the category.
     *
     * @return string The color of the category.
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Returns the date of creation of the category.
     *
     * @return DateTime La date de création de la catégorie.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Returns an array of tasks associated with this category.
     *
     * @return array An array of Task objects.
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * Returns an array of late tasks.
     *
     * @return array The array of late tasks.
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
     * @return array The array of done tasks.
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
     * Retrieves the actual tasks.
     *
     * @return array The array of actual tasks.
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
     * Sets the ID of the category.
     *
     * @param int $id The ID of the category.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Sets the title of the category.
     *
     * @param string $title The title of the category.
     * @return void
     */
    public function setTitle(string $title): void
    {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        $this->title = $title;
    }

    /**
     * Sets the description of the category.
     *
     * @param string $description The new description of the category.
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Sets the color of the category. The color must be a valid hex color.
     * 
     * @param string $color The color to set for the category.
     * @return void
     */
    public function setColor(string $color): void
    {
        if (!isset($color) || empty($color)) throw new Exception("Color cannot be empty");
        if (!preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $color)) throw new Exception("Color is not a valid hex color");
        $this->color = $color;
    }
}

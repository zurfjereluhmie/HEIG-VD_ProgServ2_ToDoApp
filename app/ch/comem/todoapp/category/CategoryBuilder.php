<?php

namespace ch\comem\todoapp\category;

use ch\comem\todoapp\task\Task;
use DateTime;
use Exception;


/**
 * This class is responsible for building Category objects.
 * 
 * @package ch\comem\todoapp\category
 */
class CategoryBuilder
{
    /**
     * @var int|null $id The ID of the category. Can be null if the category has not been assigned an ID yet.
     */
    private ?int $id;
    /**
     * @var string $title The title of the category.
     */
    private string $title;
    /**
     * @var string|null $description The description of the category.
     */
    private ?string $description;
    /**
     * @var string $color The color of the category.
     */
    private string $color;
    /**
     * @var DateTime $createdAt The date and time when the category was created.
     */
    private DateTime $createdAt;
    /**
     * @var array<Task> $tasks The tasks associated with the category.
     */
    private array $tasks;

    /**
     * CategoryBuilder constructor.
     *
     * @param string $title The title of the category.
     * @param string $hexColor The hexadecimal color code of the category.
     */
    public function __construct(string $title, string $hexColor)
    {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        if (!isset($hexColor) || empty($hexColor)) throw new Exception("Color cannot be empty");
        if (!preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $hexColor)) throw new Exception("Color is not a valid hex color");

        $this->id = null;
        $this->title = $title;
        $this->description = null;
        $this->color = $hexColor;
        $this->createdAt = new DateTime();
        $this->tasks = [];
    }

    /**
     * Sets the ID of the category.
     *
     * @param int $id The ID of the category.
     * @return CategoryBuilder The CategoryBuilder instance.
     */
    public function setId(int $id): CategoryBuilder
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Sets the title of the category.
     *
     * @param string $title The title of the category.
     * @return CategoryBuilder The CategoryBuilder instance.
     */
    public function setTitle(string $title): CategoryBuilder
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(?string $description): CategoryBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function setCreatedAt(DateTime $createdAt): CategoryBuilder
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Set the tasks for the category.
     *
     * @param array $tasks The tasks to set for the category.
     * @return CategoryBuilder The updated CategoryBuilder instance.
     */
    public function setTasks(array $tasks): CategoryBuilder
    {
        // check instance of Task
        foreach ($tasks as $task) {
            if (!$task instanceof Task) throw new Exception("Tasks must be an array of Task objects");
        }
        $this->tasks = $tasks;
        return $this;
    }

    /**
     * Returns the ID of the category.
     *
     * @return int|null The ID of the category, or null if it doesn't have an ID.
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
     * @return string|null The description of the category, or null if no description is set.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Return the color of the category.
     *
     * @return string The color of the category.
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Returns the creation date and time of the category.
     *
     * @return DateTime The creation date and time.
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Returns an array of tasks associated with this category.
     *
     * @return array The array of tasks.
     */
    public function getTasks(): array
    {
        return $this->tasks;
    }

    /**
     * Builds a Category object.
     *
     * @return Category The built Category object.
     */
    public function build(): Category
    {
        return new Category($this);
    }
}

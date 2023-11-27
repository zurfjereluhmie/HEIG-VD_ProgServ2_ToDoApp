<?php

namespace ch\comem\todoapp\task;

use ch\comem\todoapp\category\Category;
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

    public function __construct (string $title, DateTime $dueDate, Category $category) {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        if (!isset($dueDate) || empty($dueDate)) throw new Exception("Due date cannot be empty");
        if (!isset($category) || empty($category)) throw new Exception("Category cannot be empty");
        
        $this->id=null;
        $this->title = $title;
        $this->description = null;
        $this->isDone = false;
        $this->isFav = false;
        $this->dueDate = $dueDate;
        $this->category = $category;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function isDone(): bool
    {
        return $this->isDone;
    }

    public function isFav(): bool
    {
        return $this->isFav;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function build(): Task
    {
        return new Task($this);
    }

    public function setId(int $id): TaskBuilder
    {
        $this->id = $id;
        return $this;
    }

    public function setDescription(?string $description): TaskBuilder
    {
        $this->description = $description;
        return $this;
    }

    public function setIsDone(bool $isDone): TaskBuilder
    {
        $this->isDone = $isDone;
        return $this;
    }

    public function setIsFav(bool $isFav): TaskBuilder
    {
        $this->isFav = $isFav;
        return $this;
    }
}

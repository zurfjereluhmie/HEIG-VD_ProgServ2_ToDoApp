<?php

namespace ch\comem\todoapp\category;

use Exception;
use ch\comem\todoapp\category\CategoryBuilder;

/**
 * Represents a category in the Todo app.
 * 
 * @package ch\comem\todoapp\category
 */
class Category
{
    private ?int $id;
    private string $title;
    private ?string $description;
    private ?string $color;
    private array $tasks;

    public function __construct(CategoryBuilder $builder)
    {
        $this->id = $builder->getId();
        $this->title = $builder->getTitle();
        $this->description = $builder->getDescription();
        $this->color = $builder->getColor();
        $this->tasks = $builder->getTasks();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return ucfirst($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitle(string $title): void
    {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setColor(string $color): void
    {
        if (!isset($color) || empty($color)) throw new Exception("Color cannot be empty");
        if (!preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $color)) throw new Exception("Color is not a valid hex color");
        $this->color = $color;
    }
}

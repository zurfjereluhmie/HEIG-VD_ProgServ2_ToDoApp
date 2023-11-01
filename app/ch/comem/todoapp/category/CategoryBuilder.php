<?php

namespace ch\comem\todoapp\category;

use Exception;


class CategoryBuilder
{
    private ?int $id;
    private string $title;
    private ?string $description;
    private ?string $color;
    private array $tasks;

    public function __construct(string $title, string $hexColor)
    {
        if (!isset($title) || empty($title)) throw new Exception("Title cannot be empty");
        if (!isset($hexColor) || empty($hexColor)) throw new Exception("Color cannot be empty");
        if (!preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $hexColor)) throw new Exception("Color is not a valid hex color");

        $this->id = null;
        $this->title = $title;
        $this->description = null;
        $this->color = $hexColor;
        $this->tasks = [];
    }

    public function setId(int $id): CategoryBuilder
    {
        $this->id = $id;
        return $this;
    }

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

    public function setTasks(array $tasks): CategoryBuilder
    {
        $this->tasks[] = $tasks;
        return $this;
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

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }

    public function build(): Category
    {
        return new Category($this);
    }
}

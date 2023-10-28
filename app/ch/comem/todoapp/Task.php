<?php

namespace ch\comem\todoapp;

use Exception;

class Task
{
    static private $counter = 0;
    private $id;
    private $title;
    private $description;
    private $isDone;

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

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function isDone()
    {
        return $this->isDone;
    }
}

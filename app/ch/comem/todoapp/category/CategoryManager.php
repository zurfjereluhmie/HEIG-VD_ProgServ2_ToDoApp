<?php

namespace ch\comem\todoapp\category;

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_Category;
use Exception;

class CategoryManager
{
    private static ?CategoryManager $instance = null;
    private array $categories;

    private function __construct()
    {
        $this->categories = [];
        $this->loadCategories();
    }

    public static function getInstance(): CategoryManager
    {
        if (self::$instance == null) self::$instance = new CategoryManager();
        return self::$instance;
    }

    private function loadCategories(): bool
    {
        $this->categories = DbManagerCRUD_Category::getInstance()->readAll();
        return true;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getCategory(int $id): ?Category
    {
        foreach ($this->categories as $category) {
            if ($category->getId() == $id) return $category;
        }
        return null;
    }

    public function addCategory(Category &$category): bool
    {
        $dbManager = DbManagerCRUD_Category::getInstance();
        $id = $dbManager->create($category);
        if (!$id) throw new Exception("Error while creating category");
        echo $id;
        print_r($this->getCategories());
        $category = $dbManager->read($id);

        if (!$category) {
            throw new Exception("Error while creating category");
        }

        $this->loadCategories();
        return true;
    }

    public function updateCategory(Category &$category): bool
    {
        if ($category->getId() == null) throw new Exception("Category id cannot be null");

        $dbManager = DbManagerCRUD_Category::getInstance();
        $updatedCat = $dbManager->update($category->getId(), $category);

        if ($updatedCat instanceof Category) {
            $this->loadCategories();
            $category = $updatedCat;
            return true;
        }
        return false;
    }
}

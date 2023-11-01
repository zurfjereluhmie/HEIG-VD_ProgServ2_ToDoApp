<?php

namespace ch\comem\todoapp\category;

use ch\comem\todoapp\dbCRUD\DbManagerCRUD_Category;
use Exception;

/**
 * This class manages categories for the Todo app.
 * It is a singleton class, meaning that only one instance of this class can exist.
 * 
 * @package ch\comem\todoapp\category
 */
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

    /**
     * Loads the categories from the database.
     *
     * @return bool Returns true if the categories were successfully loaded, false otherwise.
     */
    private function loadCategories(): bool
    {
        $this->categories = DbManagerCRUD_Category::getInstance()->readAll();
        return true;
    }

    /**
     * Returns an array of all categories.
     *
     * @return array An array of Category objects.
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * Returns the category with the specified ID, or null if it does not exist.
     *
     * @param int $id The ID of the category to retrieve.
     * @return Category|null The category with the specified ID, or null if it does not exist.
     */
    public function getCategory(int $id): ?Category
    {
        foreach ($this->categories as $category) {
            if ($category->getId() == $id) return $category;
        }
        return null;
    }

    /**
     * Adds a category to the CategoryManager and inside the DB.
     *
     * @param Category $category The category to add.
     *
     * @return bool Returns true if the category was added successfully, false otherwise.
     */
    public function addCategory(Category &$category): bool
    {
        $dbManager = DbManagerCRUD_Category::getInstance();
        $id = $dbManager->create($category);
        if (!$id) throw new Exception("Error while creating category");

        $category = $dbManager->read($id);

        if (!$category) {
            throw new Exception("Error while creating category");
        }

        $this->loadCategories();
        return true;
    }

    /**
     * Updates a category inside the CategoryManager and inside the DB.
     *
     * @param Category $category The category to update.
     *
     * @return bool Returns true if the category was successfully updated, false otherwise.
     */
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

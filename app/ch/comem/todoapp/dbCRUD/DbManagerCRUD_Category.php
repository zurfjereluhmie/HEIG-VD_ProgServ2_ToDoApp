<?php

namespace ch\comem\todoapp\dbCRUD;

use ch\comem\todoapp\category\Category;
use ch\comem\todoapp\category\CategoryBuilder;
use Exception;

/**
 * This class extends the DbManagerCRUD class and is responsible for CRUD operations on the Category table in the database.
 * 
 * @package ch\comem\todoapp\dbCRUD
 */
class DbManagerCRUD_Category extends DbManagerCRUD
{
    private static ?DbManagerCRUD_Category $instance = null;

    private function __construct()
    {
        parent::__construct();
    }

    public static function getInstance(): DbManagerCRUD_Category
    {
        if (self::$instance === null) self::$instance = new DbManagerCRUD_Category();
        return self::$instance;
    }

    public function create(object $object): int
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");
        if (!$object instanceof Category) throw new Exception("Object is not a Category");

        $sql = "INSERT INTO Category (title, description, color, user_id) VALUES (:title, :description, :color, :user_id)";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "color" => $object->getColor(),
            "user_id" => $userId
        ]);
        if (!$res) throw new Exception("Error while creating category");
        return $this->getDb()->lastInsertId();
    }
    public function read(int $id): ?object
    {
        if (!isset($id)) throw new Exception("Id cannot be null");
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "SELECT * FROM Category WHERE id = :id AND user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(["id" => $id, "user_id" => $userId]);
        $category = $stmt->fetch();

        if (!$category) return null;

        return (new CategoryBuilder($category["title"], $category["color"]))
            ->setId($category["id"])
            ->setDescription($category["description"])
            ->build();
    }
    /**
     * Reads all categories from the database where the user_id is the same as the user_id of the logged in user.
     *
     * @return array An array of Category objects.
     */
    public function readAll(): array
    {
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "SELECT * FROM Category WHERE user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $stmt->execute(["user_id" => $userId]);
        $categories = $stmt->fetchAll();
        $result = [];
        foreach ($categories as $category) {
            $result[] = (new CategoryBuilder($category["title"], $category["color"]))
                ->setId($category["id"])
                ->setDescription($category["description"])
                ->build();
        }

        return $result;
    }
    public function update(int $id, object $object): ?object
    {
        if (!$object instanceof Category) throw new Exception("Object is not a Category");
        if (!$id == $object->getId()) throw new Exception("Id and object id do not match");

        $sql = "UPDATE Category SET title = :title, description = :description, color = :color WHERE id = :id";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute([
            "title" => $object->getTitle(),
            "description" => $object->getDescription(),
            "color" => $object->getColor(),
            "id" => $id
        ]);
        if (!$res) throw new Exception("Error while updating category");
        return $this->read($id);
    }
    public function delete(int $id): bool
    {
        if (!isset($id)) throw new Exception("Id cannot be null");
        $userId = $this->getUserId();
        if (!isset($userId)) throw new Exception("User not logged in");

        $sql = "DELETE FROM Category WHERE id = :id AND user_id = :user_id";
        $stmt = $this->getDb()->prepare($sql);
        $res = $stmt->execute(["id" => $id, "user_id" => $userId]);
        if (!$res) throw new Exception("Error while deleting category");
        return true;
    }

    /**
     * Returns the user ID of the current user.
     *
     * @return int|null The user ID of the current user, or null if not logged in.
     */
    private function getUserId(): ?int
    {
        if (!isset($_SESSION)) session_start();
        if (!isset($_SESSION["user"])) throw new Exception("User not logged in");

        return $_SESSION["user"]["id"];
    }
}
